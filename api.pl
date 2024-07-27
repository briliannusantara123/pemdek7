:- use_module(library(http/thread_httpd)).
:- use_module(library(http/http_dispatch)).
:- use_module(library(http/http_parameters)).
:- use_module(library(http/html_write)).
:- use_module(library(odbc)).
:- use_module(library(http/json)).

% Konfigurasi HTTP Server
:- http_handler(root(create_data), create_data_handler, []).
:- http_handler(root(update_data), update_data_handler, []).
:- http_handler(root(delete_data), delete_data_handler, []).
:- http_handler(root(get_data), get_data_handler, []).

% Koneksi ke database
:- odbc_connect('odbcbaju', _Connection, [user('root'), password(''), alias(db_pemilihan_baju), open(once)]).

% Entry point server
start_server :-
    http_server(http_dispatch, [port(8080)]).

% Menambahkan header CORS
add_cors_headers :-
    format('Access-Control-Allow-Origin: *~n'),
    format('Access-Control-Allow-Methods: POST, GET, OPTIONS~n'),
    format('Access-Control-Allow-Headers: Content-Type~n').

% Handler untuk request get data
get_data_handler(Request) :-
    add_cors_headers,
    http_parameters(Request, []), % Tidak ada parameter yang diharapkan
    catch(
        (   % Query untuk mengambil semua data
            Query = 'SELECT * FROM baju',
            odbc_query(db_pemilihan_baju, Query, Row),
            % Mengubah hasil query menjadi JSON
            (   Row = [] -> 
                Json = '[]'
            ;   % Mengubah hasil query menjadi JSON format
                rows_to_json(Row, Json)
            ),
            % Membuat JSON response
            format('Content-Type: application/json~n~n'),
            format('~s', [Json])
        ),
        Error,
        (   format('Content-Type: application/json~n~n'),
            format('{"error": "~w"}', [Error])
        )
    ).

% Mengubah hasil query menjadi list JSON
rows_to_json(Rows, Json) :-
    findall(JsonRow, (member(Row, Rows), row_to_json(Row, JsonRow)), JsonList),
    atomic_list_concat(JsonList, ',', JsonListStr),
    format(atom(Json), '[~s]', [JsonListStr]).

% Mengubah baris menjadi JSON format
row_to_json(row(CuacaID, AcaraID, Recommendation), Json) :-
    format(atom(Json), '{"cuaca_id": ~w, "acara_id": ~w, "recommendation": "~w"}', [CuacaID, AcaraID, Recommendation]).


% Handler untuk request create data
create_data_handler(Request) :-
    add_cors_headers,
    http_parameters(Request,
                     [ cuaca_id(CuacaID, []),
                       acara_id(AcaraID, []),
                       recommendation(Recommendation, [])
                     ]),
    atom_number(CuacaID, CuacaIDNum),
    atom_number(AcaraID, AcaraIDNum),

    % Menyiapkan query
    format(atom(Query), 'INSERT INTO baju (cuaca_id, acara_id, recommendation) VALUES (~w, ~w, \'~w\')',
           [CuacaIDNum, AcaraIDNum, Recommendation]),
    
    % Menjalankan query
    odbc_query(db_pemilihan_baju, Query, _Result),
    
    % Memberikan respons
    format('Content-Type: application/json~n~n'),
    format('{"message": "Data inserted successfully"}~n').

% Handler untuk request update data
update_data_handler(Request) :-
    add_cors_headers,
    http_parameters(Request,
                     [ cuaca_id(CuacaID, []),
                       acara_id(AcaraID, []),
                       recommendation(Recommendation, [])
                     ]),
    atom_number(CuacaID, CuacaIDNum),
    atom_number(AcaraID, AcaraIDNum),

    % Menyiapkan query
    format(atom(Query), 'UPDATE baju SET recommendation = \'~w\' WHERE cuaca_id = ~w AND acara_id = ~w',
           [Recommendation, CuacaIDNum, AcaraIDNum]),
    
    % Menjalankan query
    odbc_query(db_pemilihan_baju, Query, _Result),
    
    % Memberikan respons
    format('Content-Type: application/json~n~n'),
    format('{"message": "Data updated successfully"}~n').

% Handler untuk request delete data
delete_data_handler(Request) :-
    add_cors_headers,
    http_parameters(Request,
                     [ cuaca_id(CuacaID, []),
                       acara_id(AcaraID, [])
                     ]),
    atom_number(CuacaID, CuacaIDNum),
    atom_number(AcaraID, AcaraIDNum),

    % Menyiapkan query
    format(atom(Query), 'DELETE FROM baju WHERE cuaca_id = ~w AND acara_id = ~w',
           [CuacaIDNum, AcaraIDNum]),
    
    % Menjalankan query
    odbc_query(db_pemilihan_baju, Query, _Result),
    
    % Memberikan respons
    format('Content-Type: application/json~n~n'),
    format('{"message": "Data deleted successfully"}~n').

% Memulai server saat file ini diload
:- initialization(start_server).
