<?= $this->extend('includes/layout_logged') ?>

<?= $this->section('container') ?>
<div ng-app="client" ng-controller="clientController as vm">
    <section>
        <h3 class="my-4 dark-grey-text font-weight-bold text-center"><i class="fas fa-address-card"></i> Cadastro de Clientes</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-10">
                        <label>Pesquisar</label>
                        <input type="text" class="form-control" ng-model="vm.search">
                    </div>
                    <div class="col-sm-2 text-right mt-4">
                        <a type="button" class="btn-floating btn-info" ng-click="vm.showNewModal()"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table id="main-table" class="table table-hover table-striped table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="80px">Sequencial</th>
                                <th>Razão Social</th>
                                <th width="160px">CPF/CNPJ</th>
                                <th width="140px">Telefone</th>
                                <th width="140px">Status</th>
                                <th width="120px" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="client in vm.clients | filter:vm.search">
                            <td>{{ client.person_id }}</td>
                            <td>{{ client.company_name }}</td>
                            <td>{{ client.doc_cpf_cnpj }}</td>
                            <td>{{ client.phone }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm m-0" ng-class="client.status == 1 ? 'btn-danger' : 'btn-info'">
                                    {{ client.status == 1 ? 'Inativo' : 'Ativo' }}
                                </button>
                            </td>
                            <td>
                                <div class="text-center">
                                <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModal(client)"><i class="far fa-edit"></i></a>
                                <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.delete(client)"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Form modal -->
    <div class="modal fade" id="formModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal modal-lg">
            <div class="modal-content">
                <div class="modal-c-tabs">
                    <form method="post" action="<?= base_url('client/save')?>">
                        <ul class="nav md-tabs tabs-2 light-blue darken-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#dadosGerais" role="tab"><i class="fas fa-address-card mr-1"></i>Dados Gerais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#endereco" role="tab"><i class="fas fa-map-marked mr-1"></i>Endereço</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Dados Gerais -->
                            <div class="tab-pane fade in show active" id="dadosGerais" role="tabpanel">
                                <div class="modal-body mb-1">
                                    <div class="row">
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="person_id" name="person_id" class="form-control" readonly value="{{vm.client.person_id}}">
                                            <label for="person_id">Sequencial</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="status" id="status" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" required>
                                                <option
                                                        ng-repeat="status in vm.status track by status.value"
                                                        value="{{status.value}}"
                                                        ng-selected="status.value == vm.client.status" >{{status.description}}
                                                </option>
                                            </select>
                                            <label class="mdb-main-label">Status</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="doc_cpf_cnpj" name="doc_cpf_cnpj" maxlength="18" class="form-control" value="{{vm.client.doc_cpf_cnpj}}" required>
                                            <label for="doc_cpf_cnpj">CPF/CNPJ</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-12 md-outline">
                                            <input type="text" id="company_name" name="company_name" maxlength=100 class="form-control" value="{{vm.client.company_name}}" required>
                                            <label for="company_name">Razão Social</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-12 md-outline">
                                            <input type="text" id="fantasy_name" name="fantasy_name" maxlength="100" class="form-control" value="{{vm.client.fantasy_name}}">
                                            <label for="fantasy_name">Nome Fantasia</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-8 md-outline">
                                            <input type="email" id="email" name="email" maxlength="100" class="form-control" value="{{vm.client.email}}">
                                            <label for="email">E-mail</label>
                                        </div>
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="phone_with_ddd" name="phone" class="form-control" value="{{vm.client.phone}}">
                                            <label for="phone_with_ddd">Telefone</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Endereço -->
                            <div class="tab-pane fade" id="endereco" role="tabpanel">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="md-form col-sm-12 md-outline">
                                            <input type="text" id="address_street" name="address_street" maxlength="100" class="form-control" value="{{vm.client.address_street}}">
                                            <label for="address_street">Rua</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="address_neighborhood" name="address_neighborhood" maxlength="50" xclass="form-control" value="{{vm.client.address_neighborhood}}">
                                            <label for="address_neighborhood">Bairro</label>
                                        </div>
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="address_number" name="address_number" maxlength="20" xclass="form-control" value="{{vm.client.address_number}}">
                                            <label for="address_number">Número</label>
                                        </div>
                                        <div class="md-form col-sm-2 md-outline">
                                            <input type="text" id="address_zipcode" name="address_zipcode" maxlength="10" xclass="form-control" value="{{vm.client.address_zipcode}}">
                                            <label for="address_zipcode">CEP</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-4 md-outline">
                                            <input type="text" id="address_city" name="address_city" maxlength="50" class="form-control" value="{{vm.client.address_city}}">
                                            <label for="address_city">Cidade</label>
                                        </div>
                                        <div class="md-form col-sm-2 md-outline">
                                            <input type="text" id="address_state" name="address_state" maxlength="2" class="form-control" value="{{vm.client.address_state}}">
                                            <label for="address_state">Estado</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-sm-12 md-outline">
                                            <input type="text" id="address_reference" name="address_reference" maxlength="50" class="form-control" value="{{vm.client.address_reference}}">
                                            <label for="address_reference">Complemento</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-info">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script type="text/javascript" src="<?= base_url('assets/js/angular.min.js'); ?>"></script>
<script>
    angular.module('client', []);
    angular.module('client').controller('clientController', function($scope ,$http) {
        const vm = this;

        vm.getAll = () => {
            $http.get('<?= base_url('client/getAll') ?>')
                .then(function(response){
                    vm.clients = response.data;
                })
                .catch(function(error){
                    toastr.error(error);
                });
        }

        vm.delete = (register) => {
            $http.delete('<?= base_url('client') ?>/' + register.person_id)
                .then(function(response){
                    toastr.success('Registro excluído com sucesso!');
                    vm.getAll();
                })
                .catch(function(error){
                    toastr.error(error.data);
                });
        }

        vm.showEditModal = (register) => {
            $http.get('<?= base_url('client') ?>/' + register.person_id)
                .then(function(response){
                    vm.client = response.data;
                })
                .catch(function(error){
                    toastr.error(error);
                });

            $('#formModal').modal('show');
        }

        vm.showNewModal = () =>{
            vm.client = [];
            $('#formModal').modal('show');
        }

        $(document).on('shown.bs.modal', function (e) {
            $('#doc_cpf_cnpj').focus()
        })

        vm.getAll();

        vm.status = [
            {value: 0, description: 'Ativo'},
            {value: 1, description: 'Inativo'}
        ];
    });
</script>
<?= $this->endSection() ?>
