#imports
import sys
import os
import mysql.connector
from ollama import Client
from langchain_ollama import ChatOllama, OllamaEmbeddings
from langchain_core.prompts import ChatPromptTemplate
from langchain_community.vectorstores import InMemoryVectorStore
from langchain_core.documents import Document
from langchain_text_splitters import RecursiveCharacterTextSplitter
import json
import base64

#Configuració
MODEL_BOT = "gemma3:4b"
MODEL_EMBED = "nomic-embed-text-v2-moe"
OLLAMA_URL = 'http://192.168.1.200:11434'

client = Client(host=OLLAMA_URL)
model = ChatOllama(model=MODEL_BOT, base_url=OLLAMA_URL, temperature=0)
model_supervisor = ChatOllama(model=MODEL_BOT, base_url=OLLAMA_URL)

embeddings = OllamaEmbeddings(model=MODEL_EMBED, base_url=OLLAMA_URL)
vector_store = InMemoryVectorStore(embeddings)

#Funció per preparar el context (RAG)
def carregar_context_rag():
    #Conexió a la base de dades
    try:
        conn = mysql.connector.connect(
            host="127.0.0.1", port=3307,
            user="techcorner_admin", 
            password="admin@123",
            database="techcorner_db"
        )
        #Seleccionem els productes i la seva informació
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT nom, preu, stock, marca, descripcio FROM productes")
        
        raw_docs = []
        for p in cursor.fetchall():
            #Unim tota la info del producte en un sol text
            text_producte = "Producte: " + p['nom'] + " | Marca: " + p['marca'] + " | Preu: " + str(p['preu']) + "€ | Stock: " + str(p['stock']) + " |Descripció: " + p['descripcio']
            #Afegim com una "etiqueta" amb el nom del producte per que la ia o identifiqui en cas de tenir molta informació
            raw_docs.append(Document(page_content=text_producte, metadata={"nom": p['nom']}))

        text_splitter = RecursiveCharacterTextSplitter(chunk_size=512, chunk_overlap=128)
        
        #Trossegem la informació
        chunks = text_splitter.split_documents(raw_docs)
        vector_store.add_documents(chunks)

        cursor.close()
        conn.close()
        
    except Exception as e:
        print("Error carregant context:" + str(e))

#Funció per l'analisi d'imatges
def analitzar_imatge(imatge_path):
    if imatge_path and os.path.exists(imatge_path):

        #Zero-shot prompting
        res = client.chat(model=MODEL_BOT, messages=[
            {"role": "user", "content": "Què és això? Digues NOMÉS el nom del producte.", "images": [imatge_path]}
        ])
        return res['message']['content'].strip()
    return ""

#Funció per començar el xat
def xatejar(entrada_usuari, historial_local, es_imatge=False):
    context_cerca = entrada_usuari
    if len(historial_local) > 0:
        #Agafem l'últim missatge de la conversa com a context per a la cerca, així el bot pot tenir en compte el que s'ha dit abans
        context_cerca = historial_local[-1]['content'] + entrada_usuari

    docs_trobats = vector_store.similarity_search(context_cerca, k=8)
    #Unim els continguts dels documents trobats per a formar l'inventari que passarem al prompt de sistema
    inventari_text = "\n".join([d.page_content for d in docs_trobats])
    
    #Definim el prompt de sistema
    prompt_sistema = """Ets en TechCorner Assistant.
    COMPORTAMENT:
    1. NOMÉS pots parlar de productes de l'inventari o temes relacionats amb la tecnologia del catàleg.
    2. Si l'usuari demana "tot", "tots els productes" o "què teniu", llista TOTS els productes del context amb el seu preu.
    3. Si demana una categoria (mòbils, tablets, etc.), identifica quins productes de la llista encaixen i llista'ls
    4. Si l'usuari demana especificacions i diu "tot", dóna tota la descripció disponible de l'inventari."""
    
    #Si s'ha adjuntat una imatge afegirem noves regles per el prompt de sistema
    if es_imatge:

        prompt_sistema += """
        
        INSTRUCCIÓ D'ESTIL PER A IMATGES:
        - Si tenim aquest producte CONCRET a l'inventari, comença la teva resposta EXACTAMENT així: "Al nostre catàleg tenim " i llista'l.
        - Si tenim un producte SIMILAR a l'inventari, comença la teva resposta EXACTAMENT així: "Al nostre catàleg no tenim [producte] pero tenim " i llista NOMES 1 producte similar al sol·licitat
        - Si NO tenim el producte ni cap alternativa similar, la teva resposta ha de ser ÚNICAMENT: "Vaja, no he trobat aquest producte al catàleg."
        """
    
    #Afegim l'inventari al prompt de sistema
    prompt_sistema += "\n\nINVENTARI REAL:\n{context}"

    #Unim tot per formar el system prompt
    prompt_venedor = ChatPromptTemplate([
        ("system", prompt_sistema),
        #Afegeix tots els missatges anteriors de la conversa al prompt per a que el bot tingui memòria.
        *[(m["role"], m["content"]) for m in historial_local],
        ("human", "{query}")
    ])
    
    
    #Cridem al model i li passem el prompt de sistema, el context i la entrada de l'usuari i li demanem una resposta
    res_venedor = model.invoke(prompt_venedor.invoke({"context": inventari_text, "query": entrada_usuari}))
    resposta_proposada = res_venedor.content

    
    #Supervisor

    #Prompt de sistema del supervisor
    prompt_supervisor = ChatPromptTemplate([
        #Few-shot, tenim alguns petits exemples
        #Prompt Chaining, li estem passant la primera generació com a context per que la supervisi
        ("system", """Ets el Supervisor. Has de validar si la resposta del venedor és correcta i apropiada.
        
        CRITERI D'APROVACIÓ:
        - Si el venedor diu que tenim una 'consola' i a l'inventari hi ha una 'PlayStation' -> APROVAT (encara que no posi la paraula consola).
        - Si el venedor diu que tenim un 'mòbil' i a l'inventari hi ha un 'iPhone' -> APROVAT.
        - Si la resposta es amable i tracta al client amb respecte -> APROVAT
        - Si la resposta especifica el sock o preu d'un producte i aquesta informació és correcta segons l'inventari -> APROVAT
        DENEGA si:
        - El venedor afirma tenir una marca o model que NO surt a l'inventari (exemple: diu que tenim 'Xbox' i només hi ha 'PS5').
        - La resposta no te res a veure amb la botiga o no te res a veure amb tecnologia
        - La resposta no es amable o es ofensiva o maleducada
        - La resposta dóna informació sobre famosos, història, consells de disseny.
        
        INVENTARI:
        {context}
        
        RESPOSTA A VALIDAR: "{resposta}"
        
        Respon NOMÉS: APROVAT o DENEGAT."""),
    ])

    #Cridem al supervisor per validar la resposta del venedor
    validacio = model_supervisor.invoke(prompt_supervisor.invoke({
        "context": inventari_text, 
        "resposta": resposta_proposada
    })).content.upper()

    if "APROVAT" in validacio:
        #Si el supervisor aprova la resposta, la mostrem a l'usuari i l'afegim al historial de la conversa
        historial_local.append({"role": "user", "content": entrada_usuari})
        historial_local.append({"role": "assistant", "content": resposta_proposada})
        print(resposta_proposada)
    else:
        #Missatges en cas de que el supervisor determini la resposta com denegada
        if es_imatge:
            print("Vaja, no he trobat aquest producte al catàleg.\n")
        else:
            print("Vaja, no trobo la informació exacta sobre això.\n")

#Main
def main():
    #Configurem l'encoding a UTF-8 per evitar problemes amb accents entre PHP i Python
    sys.stdout.reconfigure(encoding='utf-8')

    #Si no tenim cap entrada de l'usuari mostrem un error i sortim
    if len(sys.argv) < 2:
        print("Error: No s'ha proporcionat cap missatge.")
        return

    #Agafem l'entrada de l'usuari, la ruta de la imatge (si n'hi ha) i el historial de la conversa (si n'hi ha)
    entrada_usuari = sys.argv[1]

    if len(sys.argv) > 2:
        ruta_imatge = sys.argv[2]
    else:
        ruta_imatge = "none"


    if len(sys.argv) > 3:
        historial_b64 = sys.argv[3]
    else:
        historial_b64 = "none"


    historial_local = []
    
    if historial_b64 and historial_b64 != "none":
        try:
            #Decodifiquem el historial que ens arriba en base64 des de PHP i el convertim a format JSON
            historial_json = base64.b64decode(historial_b64).decode('utf-8')
            historial_local = json.loads(historial_json)
        except Exception as e:
            #Si falla, continuem sense historial, pero evitem que el bot "peti"
            pass

    #Carreguem el context
    carregar_context_rag()

    es_imatge = False
    query_final = entrada_usuari

    #Si hi ha una imatge vàlida, primer l'analitzem
    if ruta_imatge != "none" and os.path.exists(ruta_imatge):
        descripcio_imatge = analitzar_imatge(ruta_imatge)
        if descripcio_imatge:
            print("Veig: " + descripcio_imatge + "\n")
            #Formulem una pregunta amb la descripció de la imatge
            query_final = "Teniu " + descripcio_imatge + "?"
            es_imatge = True
    
    #Cridem la funció per obtenir la resposta
    xatejar(query_final, historial_local, es_imatge=es_imatge)

if __name__ == "__main__":
    main()