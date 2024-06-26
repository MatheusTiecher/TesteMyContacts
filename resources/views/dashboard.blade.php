<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Contacts') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        <!-- Componente de Pesquisa -->
                        <div class="col-4">
                            <div class="d-flex">
                                <h2 class="text-2xl font-semibold w-100">Contatos</h2>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addContactModal">Add</a>
                            </div>
                            <div class="mb-1">
                                <label for="type" class="form-label">Tipo</label>
                                <select class="form-select" id="type" aria-label="Type contact">
                                    <option value="1" selected>Pessoal</option>
                                    <option value="2">Profissional</option>
                                    <option value="3">Familiar</option>
                                    <option value="4">Outro</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="search" class="form-label">Pesquisa</label>
                                <input type="text" id="search" class="form-control" placeholder="Pesquisa...">
                            </div>
                            <!-- Lista de Contatos -->
                            <h3>Lista de Contatos:</h3>
                            <ul class="list-group">
                            </ul>
                        </div>
                        <!-- Lista no mapa -->
                        <div class="col-8 text-right">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Contact -->
    <div class="modal fade" id="addContactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Adicionar contato</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addContactForm" action="javascript:criarContato()">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Nome do contato *</label>
                                <input type="text" class="form-control" id="name" placeholder="Matheus Tiecher"
                                    required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00"
                                    required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="cellphone" class="form-label">Celular *</label>
                                <input type="text" class="form-control" id="cellphone" placeholder="(00) 00000-0000"
                                    required>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="type" class="form-label">Tipo *</label>
                                <select class="form-select" id="type" aria-label="Type contact">
                                    <option value="1" selected>Pessoal</option>
                                    <option value="2">Profissional</option>
                                    <option value="3">Familiar</option>
                                    <option value="4">Outro</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="zipcode" class="form-label">CEP *</label>
                                <input type="text" class="form-control" id="zipcode" placeholder="00000-000"
                                    required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="city" class="form-label">Cidade *</label>
                                <input type="text" class="form-control" id="city" readonly placeholder="Cidade"
                                    disabled>
                                <input type="hidden" id="city_id">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="state" class="form-label">Estado *</label>
                                <input type="text" class="form-control" id="state" readonly placeholder="UF"
                                    disabled>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="address" class="form-label">Endereço *</label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="Rua, Avenida, etc." required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="district" class="form-label">Bairro *</label>
                                <input type="text" class="form-control" id="district" placeholder="Bairro"
                                    required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="number" class="form-label">Número *</label>
                                <input type="text" class="form-control" id="number" placeholder="Número"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit Contact -->
    <div class="modal fade" id="editContactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar contato</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContactForm" action="#">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Nome do contato *</label>
                                <input type="text" class="form-control edit_name" id="name"
                                    placeholder="Matheus Tiecher" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control edit_cpf" id="cpf"
                                    placeholder="000.000.000-00" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="cellphone" class="form-label">Celular *</label>
                                <input type="text" class="form-control edit_cellphone" id="cellphone"
                                    placeholder="(00) 00000-0000" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="type" class="form-label">Tipo *</label>
                                <select class="form-select edit_type" id="type" aria-label="Type contact">
                                    <option value="1">Pessoal</option>
                                    <option value="2">Profissional</option>
                                    <option value="3">Familiar</option>
                                    <option value="4">Outro</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="zipcode" class="form-label">CEP *</label>
                                <input type="text" class="form-control edit_zipcode" id="zipcode"
                                    placeholder="00000-000" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="city" class="form-label">Cidade *</label>
                                <input type="text" class="form-control edit_city" id="city" readonly
                                    placeholder="Cidade" disabled>
                                <input type="hidden" id="city_id" class="edit_city_id">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="state" class="form-label">Estado *</label>
                                <input type="text" class="form-control edit_state" id="state" readonly
                                    placeholder="UF" disabled>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="address" class="form-label">Endereço *</label>
                                <input type="text" class="form-control edit_address" id="address"
                                    placeholder="Rua, Avenida, etc." required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="district" class="form-label">Bairro *</label>
                                <input type="text" class="form-control edit_district" id="district"
                                    placeholder="Bairro" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="number" class="form-label">Número *</label>
                                <input type="text" class="form-control edit_number" id="number"
                                    placeholder="Número" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&callback=initMap&libraries=places"
        defer></script>
    <script>
        let map;
        let Marker;
        let allMarkers = [];

        // Função para remover todos os marcadores do mapa
        function removeAllMarkers() {
            allMarkers.forEach(marker => marker.setMap(null)); // Remove o marcador do mapa
            allMarkers = []; // Limpa o array
        }

        // Função para adicionar marcadores ao mapa
        function addMarkers(coordenadas) {
            coordenadas.forEach(coordinate => {
                const marker = new google.maps.Marker({
                    position: coordinate,
                    map: map,
                });
                allMarkers.push(marker); // Armazena o marcador no array
            });
        }

        async function initMap() {
            //@ts-ignore
            const {
                Map,
                Marker: MarkerClass
            } = google.maps;

            map = new Map(document.getElementById('map'), {
                center: {
                    lat: -25.4441627,
                    lng: -49.2556925
                },
                zoom: 12,
            });

            Marker = MarkerClass; // Atribui a referência globalmente
        }

        // quando o documento estiver pronto carrerga a lista
        document.addEventListener('DOMContentLoaded', function() {
            listar();
            initMap();
        });

        // sempre que o campo de pesquisa e o tipo mudar, chama a funcao listar
        document.getElementById('search').addEventListener('input', listar);
        document.getElementById('type').addEventListener('change', listar);

        // sempre que o campo de cep for maior que 8, chama a funcao getCep
        document.getElementById('zipcode').addEventListener('input', function() {
            if (document.getElementById('zipcode').value.length >= 8) {
                getCep(document.getElementById('zipcode').value);
            }
        });

        // sempre que o campo class .edit_zipcode de cep for maior que 8, chama a funcao getCep
        document.querySelector('.edit_zipcode').addEventListener('input', function() {
            if (document.querySelector('.edit_zipcode').value.length >= 8) {
                getCep(document.querySelector('.edit_zipcode').value);
            }
        });

        // Função para criar um novo contato via API REST
        function listar(contatoFoco = null) {
            // Recuperar o token de autenticação da sessão
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Dados do novo contato
            var requestSearch = {
                type: document.getElementById('type').value,
                search: document.getElementById('search').value,
                _token: token // Adicionando o token de autenticação
            };

            // Requisição POST para criar um novo contato
            fetch('/api/contacts?search=' + requestSearch.search + '&type=' + requestSearch.type, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token, // Passando o token de autenticação no header
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Contatos:', data);

                    // chama a funcao atualizarLista
                    atualizarLista(data.data);

                    // Recupera as coordenadas dos contatos
                    let coordenadas = data.data.map(contact => {
                        return {
                            lat: parseFloat(contact.latitude),
                            lng: parseFloat(contact.longitude),
                        };
                    });

                    // Remove todos os marcadores do mapa
                    removeAllMarkers();

                    // Adiciona novos marcadores ao mapa
                    addMarkers(coordenadas);

                    // verifica se tem um contato para focar se nao pega o promeiro da lista
                    if (contatoFoco) {
                        map.setCenter({
                            lat: parseFloat(contatoFoco.latitude),
                            lng: parseFloat(contatoFoco.longitude)
                        });
                    } else {
                        map.setCenter({
                            lat: parseFloat(data.data[0].latitude),
                            lng: parseFloat(data.data[0].longitude)
                        });
                    }

                })
                .catch(error => {
                    console.error('Erro ao listar contatos:', error);
                });
        }

        // Função para atualizar a lista de contatos
        function atualizarLista(data) {
            // Recuperar a lista de contatos
            var lista = document.querySelector('.list-group');
            lista.innerHTML = '';

            // Adicionar cada contato na lista
            data.forEach(function(contact) {
                // Criar um item de lista
                var item = document.createElement('li');
                item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                item.innerHTML = contact.name;

                // adiciona o endereco do item pegando de full_address e adiciona o tipo de contato pegando de type_description e adiciona o cpf e telefone
                item.innerHTML += ' - ' + contact.full_address + ' - ' + contact.type_description + ' - ' + contact
                    .cpf + ' - ' + contact.cellphone;

                // Adicionar botões de ação
                var btnGroup = document.createElement('div');
                btnGroup.classList.add('btn-group');
                btnGroup.setAttribute('role', 'group');

                // Botão de editar
                var btnEdit = document.createElement('button');
                btnEdit.classList.add('btn', 'btn-outline-primary');
                btnEdit.innerHTML = 'Editar';
                btnEdit.addEventListener('click', function() {
                    openEditModal(contact);
                });
                btnGroup.appendChild(btnEdit);

                // Botão de excluir
                var btnDelete = document.createElement('button');
                btnDelete.classList.add('btn', 'btn-outline-danger');
                btnDelete.innerHTML = 'Excluir';
                btnDelete.addEventListener('click', function() {
                    if (confirm('Tem certeza que deseja excluir este contato?')) {
                        deleteContact(contact.id);
                    }
                });
                btnGroup.appendChild(btnDelete);

                // Adicionar botões ao item
                item.appendChild(btnGroup);

                // Adicionar item à lista
                lista.appendChild(item);
            });
        }

        function deleteContact(id) {
            // Recuperar o token de autenticação da sessão
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Requisição DELETE para excluir um contato
            fetch('/api/contacts/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token, // Passando o token de autenticação no header
                    }
                })
                // verifica se status code header é 204
                .then(response => {
                    if (response.status === 204) {
                        // Atualizar a lista de contatos
                        listar();

                        // Exibir mensagem de sucesso
                        alert('Contato excluído com sucesso!');
                    }
                })
                .catch(error => {
                    console.error('Erro ao excluir contato:', error);
                });
        }

        // /api/viacep/{cep} - pega o cep 
        function getCep(cep) {
            // Recuperar o token de autenticação da sessão
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Remove caracteres não numéricos
            cep = cep.replace(/\D/g, '');

            fetch('/api/viacep/' + cep, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token, // Passando o token de autenticação no header
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('district').value = data.bairro;
                    document.getElementById('city').value = data.localidade;
                    document.getElementById('state').value = data.uf;
                    document.getElementById('city_id').value = data.ibge;
                    document.getElementById('address').value = data.logradouro;

                    // campos do editar
                    document.querySelector('.edit_district').value = data.bairro;
                    document.querySelector('.edit_city').value = data.localidade;
                    document.querySelector('.edit_state').value = data.uf;
                    document.querySelector('.edit_city_id').value = data.ibge;
                    document.querySelector('.edit_address').value = data.logradouro;
                })
                .catch(error => {
                    console.error('Erro ao listar contatos:', error);
                });
        }

        // criar um novo contato
        function criarContato() {
            // Recuperar o token de autenticação da sessão
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // transforma o cep em um numero
            var cep = document.getElementById('zipcode').value.replace(/\D/g, '');
            // transforma o CPF em um numero
            var cpf = document.getElementById('cpf').value.replace(/\D/g, '');

            // Dados do novo contato
            var request = {
                name: document.getElementById('name').value,
                cpf: cpf,
                cellphone: document.getElementById('cellphone').value,
                type: document.getElementById('type').value,
                zipcode: cep,
                city_id: document.getElementById('city_id').value,
                district: document.getElementById('district').value,
                number: document.getElementById('number').value,
                address: document.getElementById('address').value,
                _token: token // Adicionando o token de autenticação
            };

            // Requisição POST para criar um novo contato
            fetch('/api/contacts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token, // Passando o token de autenticação no header
                    },
                    body: JSON.stringify(request)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors && Object.keys(data.errors).length > 0) {
                        console.log('erros:', data);
                        // marca os campos que deram erro no formulario
                        for (var key in data.errors) {
                            document.getElementById(key).classList.add('is-invalid');
                        }

                        throw new Error('Erro ao criar contato');
                    } else {
                        console.log('Contato criado:', data);

                        // Fechar o modal
                        var modal = document.getElementById('addContactModal');
                        var modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();

                        // Limpar os campos do formulário
                        document.getElementById('name').value = '';
                        document.getElementById('cpf').value = '';
                        document.getElementById('cellphone').value = '';
                        document.getElementById('type').value = '1';
                        document.getElementById('zipcode').value = '';
                        document.getElementById('address').value = '';
                        document.getElementById('state').value = '';
                        document.getElementById('city_id').value = '';
                        document.getElementById('district').value = '';
                        document.getElementById('number').value = '';

                        // Atualizar a lista de contatos
                        listar(data.data);
                    }
                }).catch(error => {
                    // cria alerta 
                    alert('Erro ao criar contato');
                });
        }

        // gerar o modal de edicao
        function openEditModal(contact) {
            // Preencher os campos do formulário class edit_*
            document.querySelector('.edit_name').value = contact.name;
            document.querySelector('.edit_cpf').value = contact.cpf;
            document.querySelector('.edit_cellphone').value = contact.cellphone;
            document.querySelector('.edit_type').value = contact.type;
            document.querySelector('.edit_zipcode').value = contact.zipcode;
            document.querySelector('.edit_city').value = contact.city.description;
            document.querySelector('.edit_state').value = contact.city.uf;
            document.querySelector('.edit_city_id').value = contact.city.id;
            document.querySelector('.edit_address').value = contact.address;
            document.querySelector('.edit_district').value = contact.district;
            document.querySelector('.edit_number').value = contact.number;

            // Exibir o modal editContactModal
            var modal = new bootstrap.Modal(document.getElementById('editContactModal'));
            modal.show();

            // Adicionar o evento de submit ao formulário
            document.getElementById('editContactForm').addEventListener('submit', function(event) {
                event.preventDefault();
                editarContato(contact.id);
            });
        }

        // editar um contato
        function editarContato(contactId) {
            // Recuperar o token de autenticação da sessão
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // transforma o cep em um numero
            var cep = document.querySelector('.edit_zipcode').value.replace(/\D/g, '');
            // transforma o CPF em um numero
            var cpf = document.querySelector('.edit_cpf').value.replace(/\D/g, '');

            // Dados do contato atualizado
            var request = {
                name: document.querySelector('.edit_name').value,
                cpf: cpf,
                cellphone: document.querySelector('.edit_cellphone').value,
                type: document.querySelector('.edit_type').value,
                zipcode: cep,
                city_id: document.querySelector('.edit_city_id').value,
                district: document.querySelector('.edit_district').value,
                number: document.querySelector('.edit_number').value,
                address: document.querySelector('.edit_address').value,
                id: contactId,
                _token: token // Adicionando o token de autenticação
            };

            // Requisição PUT para atualizar o contato
            fetch('/api/contacts/' + contactId, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token, // Passando o token de autenticação no header
                    },
                    body: JSON.stringify(request)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors && Object.keys(data.errors).length > 0) {
                        console.log('erros:', data);
                        // marca os campos que deram erro no formulario
                        for (var key in data.errors) {
                            document.querySelector('.edit_' + key).classList.add('is-invalid');
                        }

                        throw new Error('Erro ao editar contato');
                    } else {
                        console.log('Contato editado:', data);

                        // Fechar o modal
                        var modal = document.getElementById('editContactModal');
                        var modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();

                        // Limpar os campos do formulário
                        document.querySelector('.edit_name').value = '';
                        document.querySelector('.edit_cpf').value = '';
                        document.querySelector('.edit_cellphone').value = '';
                        document.querySelector('.edit_type').value = '1';
                        document.querySelector('.edit_zipcode').value = '';
                        document.querySelector('.edit_address').value = '';
                        document.querySelector('.edit_state').value = '';
                        document.querySelector('.edit_city_id').value = '';
                        document.querySelector('.edit_district').value = '';
                        document.querySelector('.edit_number').value = '';

                        // Atualizar a lista de contatos
                        listar(data.data);
                    }
                }).catch(error => {
                    // cria alerta 
                    alert('Erro ao editar contato');
                });
        }
    </script>

</x-app-layout>
