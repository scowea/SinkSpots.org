<?php
//------------------------------------------------------------------------------
//*** Italiano (it) 
//------------------------------------------------------------------------------
function setLanguage(){ 
    $lang['='] = "=";  // "equal"; 
    $lang['>'] = ">";  // "bigger"; 
    $lang['<'] = "<";  // "smaller";
    $lang['add'] = "Aggiungi"; 
    $lang['add_new'] = "+ Aggiungi nuovo"; 
    $lang['add_new_record'] = "Aggiungi nuovo record";
    $lang['add_new_record_blocked'] = "Controllo di sicurezza: nell'inserimento di un nuovo record! Controlla i tuoi settaggi, l'operazione non e' permessa!";    
    $lang['adding_operation_completed'] = "Inserimento completato!";
    $lang['adding_operation_uncompleted'] = "Inserimento non completato!";
    $lang['and'] = "and";
    $lang['any'] = "molti"; 
    $lang['ascending'] = "Ascendente"; 
    $lang['back'] = "Indietro"; 
    $lang['cancel'] = "Annulla"; 
    $lang['cancel_creating_new_record'] = "Sei sicuro di voler cancellare l'inserimento del nuovo record?";
    $lang['check_all'] = "Controlla tutti";
    $lang['clear'] = "Cancella";    
    $lang['create'] = "Crea"; 
    $lang['create_new_record'] = "Crea nuovo record"; 
    $lang['current'] = "corrente";         
    $lang['delete'] = "Elimina"; 
    $lang['delete_record'] = "Elimina il record";
    $lang['delete_record_blocked'] = "Controllo di sicurezza: nella cancellazione del record! Controlla i tuoi settaggi, l'operazione non e' permessa!";    
    $lang['delete_selected'] = "Cancella i selezionati";
    $lang['delete_selected_records'] = "Sei sicuro di voler cancellare i record selezionati?";
    $lang['delete_this_record'] = "Sei sicuro di voler cancellare il record selezionato?";         
    $lang['deleting_operation_completed'] = "L'operazione di cancellazione e' terminata con successo!";
    $lang['deleting_operation_uncompleted'] = "L'operazione di cancellazione non e' stata completata!";
    $lang['descending'] = "Discendante";
    $lang['details'] = "Dettagli";
    $lang['details_selected'] = "Dettagli selezionati";
    $lang['edit'] = "Modifica";
    $lang['edit_selected'] = "Modifica i selezionati";
    $lang['edit_record'] = "Modifica record";
    $lang['edit_selected_records'] = "Sei sicuro di voler modificare i record selezionati?";   
    $lang['errors'] = "Errori";
    $lang['export_to_excel'] = "Esporta su Excel";
    $lang['export_to_pdf'] = "Esporta su PDF";    
    $lang['export_to_xml'] = "Esporta su XML";
    $lang['export_message'] = "<label class=\"default_class_label\">Il file _FILE_ e' pronto. Dopo avere finito il download,</label> <a class=\"default_class_error_message\" href=\"javascript: window.close();\">Chiudi la finestra</a>.";
    $lang['field'] = "Campo"; 
    $lang['field_value'] = "Valore del campo";
    $lang['file_find_error'] = "Non riesco a trovare il file: <b>_FILE_</b>. <br>Controlla che il file esista e che il percorso sia corretto!";
    $lang['file_opening_error'] = "Non posso aprire il file . Controlla i tuoi permessi.";
    $lang['file_writing_error'] = "Non posso scrivere il file. Controlla i tuoi permessi!";
    $lang['file_invalid file_size'] = "Grandezza del file invalida";
    $lang['file_uploading_error'] = "C'e' un errore quando eseguo l' uploading, prova ancora prego!";
    $lang['file_deleting_error'] = "C'e' un errore nella cancellazione!";
    $lang['first'] = "primo";      
    $lang['handle_selected_records'] = "Sei sicuro di voler trattare il record selezionato?";
    $lang['hide_search'] = "Evidenzia la ricerca";
    $lang['last'] = "ultimo"; 
    $lang['like'] = "like";
    $lang['like%'] = "like%";  // "begins with"; 
    $lang['%like'] = "%like";  // "ends with";
    $lang['%like%'] = "%like%";  
    $lang['loading_data'] = "Caricamento dati...";
    $lang['max'] = "max";    
    $lang['next'] = "successivo"; 
    $lang['no'] = "No";        
    $lang['no_data_found'] = "Nessun valore trovato"; 
    $lang['no_data_found_error'] = "Nessun valore trovato! Controlla la sintassi SQL!<br>Si prega di fare attenzione alla sintassi ed eventuali simboli.";        
    $lang['no_image'] = "Nessuna Immagine";
    $lang['not_like'] = "not like";
    $lang['of'] = "di";
    $lang['operation_was_already_done'] = "L'operazione e' gia' stata completata! Non puoi rifarla ancora.";            
    $lang['or'] = "or";    
    $lang['pages'] = "Pagine";        
    $lang['page_size'] = "Lunghezza pagine"; 
    $lang['previous'] = "precedente";    
    $lang['printable_view'] = "Versione stampabile";    
    $lang['print_now'] = "Stampa ora";
    $lang['print_now_title'] = "Clicca qui per stampare questa pagina";
    $lang['record_n'] = "Record #";
    $lang['refresh_page'] = "Rinfresca la pagina";    
    $lang['remove'] = "Rimuovi";
    $lang['reset'] = "Reset";
    $lang['results'] = "Risultati"; 
    $lang['required_fields_msg'] = "<font color='#cd0000'>*</font>Gli oggetti marcati con asterisco sono obbligatori";
    $lang['search'] = "Cerca"; 
    $lang['search_d'] = "Cerca"; // (description) 
    $lang['search_type'] = "Tipo di ricerca"; 
    $lang['select'] = "seleziona"; 
    $lang['set_date'] = "Imposta la data";
    $lang['sort'] = "Ordinamento";    
    $lang['total'] = "Totale";
    $lang['turn_on_debug_mode'] = "Per maggiori informazioni, attiva il modo debug.";
    $lang['uncheck_all'] = "Deseleziona tutti";
    $lang['unhide_search'] = "Deseleziona la ricerca";
    $lang['unique_field_error'] = "Il campo _FIELD_ permette solo valori univoci - prego reimmetti!";
    $lang['update'] = "Aggiorna"; 
    $lang['update_record'] = "Aggiorna record";
    $lang['update_record_blocked'] = "Controllo sicurezza: tentativo di aggiornare un record! Controlla i tuoi settaggi, l'operazione non e' permessa!";    
    $lang['updating_operation_completed'] = "L'operazione di aggiornamento e' stata completata con successo!";
    $lang['updating_operation_uncompleted'] = "L'operazione di aggiornamento non e' stata completata!";
    $lang['upload'] = "Caricamento";
    $lang['view'] = "Mostra"; 
    $lang['view_details'] = "Mostra i dettagli";
    $lang['warnings'] = "Attenzione";
    $lang['with_selected'] = "Con selezione";
    $lang['wrong_field_name'] = "Nome campo errato";
    $lang['wrong_parameter_error'] = "Parametro in errore [<b>_FIELD_</b>]: _VALUE_";
    $lang['yes'] = "Si";

    // date-time
    $lang['day']    = "giorno";
    $lang['month']  = "mese";
    $lang['year']   = "anno";
    $lang['hour']   = "ore";
    $lang['min']    = "minuti";
    $lang['sec']    = "secondi";
    $lang['months'][1] = "Gennaio";
    $lang['months'][2] = "Febbraio";
    $lang['months'][3] = "Marzo";
    $lang['months'][4] = "Aprile";
    $lang['months'][5] = "Maggio";
    $lang['months'][6] = "Giugno";
    $lang['months'][7] = "Luglio";
    $lang['months'][8] = "Agosto";
    $lang['months'][9] = "Settembre";
    $lang['months'][10] = "Ottobre";
    $lang['months'][11] = "Novembre";
    $lang['months'][12] = "Dicembre";
        
    return $lang; 
}
?>