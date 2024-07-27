<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        @yield('content')

        @if(Request::is('/'))
            <div class="card">
                <div class="card-header text-center font-weight-bold">
                    Home
                </div>
                <div class="card-body">
                    <div class="box">
                        <section class="bg-light py-5">
                            <div class="container text-center">
                                <h1 class="display-4">Olá, eu sou Pablo Ramires</h1>
                                <p class="lead">Vamos falar sobre soluções e tecnologia?</p>
                                <div class="mt-4">
                                    <a href="https://github.com/ramirespoa" target="_blank"><i class="fab fa-github"></i> GitHub</a>
                                    <a href="https://www.linkedin.com/in/pablo-ramires-silva" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
                                    <a href="https://wa.me/5551991485559" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                </div>
                                <div class="mt-4">
                                    <a href="/fornecedores"><i class="fa-file-text"></i> Seguir para o desafio proposto.</a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif

    </div>
    @yield('scripts')
</body>
</html>
