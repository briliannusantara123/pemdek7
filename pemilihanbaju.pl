:- use_module(library(http/thread_httpd)).
:- use_module(library(http/http_dispatch)).
:- use_module(library(http/http_parameters)).
:- use_module(library(http/html_write)).
:- use_module(library(odbc)).

% Menghubungkan ke database
connect_db :-
    odbc_connect('odbcbaju', _Connection, [user(root), password(''), alias(db_pemilihan_baju), open(once)]).

% Handler untuk halaman utama pemilihan baju
:- http_handler(root(.), pilih_baju, []).
% Handler untuk halaman hasil pemilihan baju
:- http_handler(root(hasil), hasil, []).
% Handler untuk halaman tambah data baju
:- http_handler(root(tambah_baju), tambah_baju, []).
% Handler untuk menangani form tambah data baju
:- http_handler(root(simpan_baju), simpan_baju, []).
% Handler untuk halaman menampilkan semua data baju
:- http_handler(root(semua_baju), semua_baju, []).

% Halaman untuk menampilkan form pemilihan baju
pilih_baju(_Request) :-
    reply_html_page(
        [title('Aplikasi Pemilihan Baju')],
        [ h1('Aplikasi Pemilihan Baju'),
          form([action='/hasil', method='GET'],
               [ p('Masukkan kondisi cuaca:'),
                 input([type=text, name=cuaca]),
                 p('Masukkan jenis kegiatan:'),
                 input([type=text, name=kegiatan]),
                 p(input([type=submit, value='Cari Baju']))
               ]),
          p(a([href='/tambah_baju'], 'Tambah Data Baju')),
          p(a([href='/semua_baju'], 'Lihat Semua Data Baju'))
        ]).

% Halaman untuk menampilkan hasil pemilihan baju
hasil(Request) :-
    http_parameters(Request, [cuaca(Cuaca, []), kegiatan(Kegiatan, [])]),
    (   get_recommendation(Cuaca, Kegiatan, Baju)
    ->  true
    ;   Baju = 'Pakai baju yang nyaman sesuai kondisi'),
    reply_html_page(
        [title('Hasil Pemilihan Baju')],
        [ h1('Hasil Pemilihan Baju'),
          p(['Cuaca: ', Cuaca]),
          p(['Kegiatan: ', Kegiatan]),
          p(['Baju yang direkomendasikan: ', Baju])
        ]).

% Halaman untuk menampilkan form tambah data baju
tambah_baju(_Request) :-
    reply_html_page(
        [title('Tambah Data Baju')],
        [ h1('Tambah Data Baju'),
          form([action='/simpan_baju', method='POST'],
               [ p('Masukkan kondisi cuaca:'),
                 input([type=text, name=cuaca]),
                 p('Masukkan jenis kegiatan:'),
                 input([type=text, name=kegiatan]),
                 p('Masukkan rekomendasi baju:'),
                 input([type=text, name=rekomendasi]),
                 p(input([type=submit, value='Simpan']))
               ])
        ]).

% Handler untuk menyimpan data baju ke database
simpan_baju(Request) :-
    http_parameters(Request,
        [cuaca(Cuaca, []),
         kegiatan(Kegiatan, []),
         rekomendasi(Rekomendasi, [])
        ]),
    simpan_data_baju(Cuaca, Kegiatan, Rekomendasi),
    reply_html_page(
        [title('Data Baju Tersimpan')],
        [ h1('Data Baju Tersimpan'),
          p('Data baju berhasil disimpan.'),
          p(a([href='/'], 'Kembali ke halaman utama'))
        ]).

% Menyimpan data baju ke database
simpan_data_baju(Cuaca, Kegiatan, Rekomendasi) :-
    connect_db,
    odbc_query(db_pemilihan_baju,
               'INSERT INTO baju (cuaca_id, acara_id, recommendation) VALUES (?,?,?)',
               [Cuaca, Kegiatan, Rekomendasi]).

% Mendapatkan rekomendasi baju dari database
get_recommendation(Cuaca, Kegiatan, Recommendation) :-
    connect_db,
    odbc_query(db_pemilihan_baju,
               'SELECT recommendation FROM baju WHERE cuaca_id = (SELECT id FROM Weather WHERE condition = ?) AND acara_id = (SELECT id FROM Activity WHERE type = ?)',
               row(Recommendation),
               [parameter(Cuaca), parameter(Kegiatan)]).

% Handler untuk menampilkan semua data baju
semua_baju(_Request) :-
    connect_db,
    odbc_query(db_pemilihan_baju,
               'SELECT id, cuaca_id, acara_id, recommendation FROM baju',
               Rows),
    reply_html_page(
        [title('Semua Data Baju')],
        [ h1('Semua Data Baju'),
          table(
              [ border(1) ],
              [ tr([ th('ID'), th('Cuaca ID'), th('Kegiatan ID'), th('Rekomendasi') ]),
                \render_rows(Rows)
              ]
          ),
          p(a([href='/'], 'Kembali ke halaman utama'))
        ]).

% Render rows dalam format HTML
render_rows([]) --> [].
render_rows([row(ID, CuacaID, AcaraID, Recommendation)|Rest]) -->
    html(tr([ td(ID), td(CuacaID), td(AcaraID), td(Recommendation) ])),
    render_rows(Rest).

% Predikat Untuk memulai server pada port 8080
start_server :-
    http_server(http_dispatch, [port(8080)]).

% Memulai server saat file ini diload
:- initialization(start_server).
