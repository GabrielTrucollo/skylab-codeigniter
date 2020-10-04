<?= $this->extend('includes/layout_logged') ?>

<?= $this->section('container') ?>
    <div ng-app="clientSoftwareUpdate" ng-controller="clientSoftwareUpdateController as vm">
        <!-- Section: Basic examples -->
        <section>
            <h3 class="dark-grey-text font-weight-bold text-center"><i class="fas fa-sync-alt"></i> Atualizações</h3>
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
                                <th>Cliente</th>
                                <th width="300px">Software</th>
                                <th width="120px">Versão</th>
                                <th width="120px" class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="softwareUpdate in vm.clientSoftwareUpdates | filter:vm.search">
                                <td>{{ softwareUpdate.person_software_update_id }}</td>
                                <td>{{ softwareUpdate.client }}</td>
                                <td>{{ softwareUpdate.software }}</td>
                                <td>{{ softwareUpdate.version }}</td>
                                <td>
                                    <div class="text-center">
                                        <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModal(softwareUpdate)"><i class="far fa-edit"></i></a>
                                        <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.delete(softwareUpdate)"><i class="fas fa-trash"></i></a>
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
                    <div class="modal-header info-color-dark text-white">
                        <h5 class="heading lead"><i class="fas fa-sync-alt"></i> Atualizações</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="<?= base_url('client-software-update/save')?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="md-form col-sm-4 md-outline">
                                    <input type="text" id="person_software_update_id" name="person_software_update_id" class="form-control" readonly value="{{vm.personSoftwareUpdate.person_software_update_id}}">
                                    <label for="person_software_update_id">Sequencial</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <select name="person_id" id="person_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" onchange="clientChanged()" searchable="Pesquisar...">
                                        <option value="" disabled selected>Pesquisa de Clientes</option>
                                        <option
                                                ng-repeat="client in vm.clients track by client.person_id"
                                                value="{{client.person_id}}"
                                                ng-selected="client.person_id == vm.personSoftwareUpdate.person_id" >{{client.company_name}}
                                        </option>
                                    </select>
                                    <label class="mdb-main-label">Cliente</label>
                                </div>
                                <div class="md-form col-sm-4 md-outline">
                                    <input type="text" id="software" name="software" class="form-control" readonly>
                                    <label for="name">Software</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="md-form col-sm-12 md-outline">
                                    <input type="text" id="version" name="version" maxlength="50" class="form-control" value="{{vm.personSoftwareUpdate.version}}" required>
                                    <label for="name">Versão</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-info">Salvar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="<?= base_url('assets/js/angular.min.js'); ?>"></script>
    <script>
        angular.module('clientSoftwareUpdate', []);
        angular.module('clientSoftwareUpdate').controller('clientSoftwareUpdateController', function($scope ,$http) {
            const vm = this;

            vm.getAll = () => {
                $http.get('<?= base_url('client-software-update/getAll') ?>')
                    .then(function(response){
                        vm.clientSoftwareUpdates = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
            }

            vm.delete = (register) => {
                $http.delete('<?= base_url('client-software-update') ?>/' + register.person_software_update_id)
                    .then(function(response){
                        toastr.success('Registro excluído com sucesso!');
                        vm.getAll();
                    })
                    .catch(function(error){
                        toastr.error(error.data);
                    });
            }

            clientChanged = () => {
                var clientId = $('#person_id').val();
                if (!clientId){
                    clientId = this.personSoftwareUpdate.person_id;
                }

                let client = this.clients.find(x => x.person_id == clientId);
                let software = this.softwares.find(x => x.software_id == client?.software_id);

                var softwareField;
                switch (!software) {
                    case true:
                        softwareField  = 'Não localizado';
                        break;

                    default:
                        softwareField =  software.name;
                        break;
                }

                // Update field
                $('#software').val(softwareField);
            }

            vm.showEditModal = (register) => {
                $http.get('<?= base_url('client-software-update') ?>/' + register.person_software_update_id)
                    .then(function(response){
                        vm.personSoftwareUpdate = response.data;
                        clientChanged();
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });

                $('#formModal').modal('show');
            }

            vm.showNewModal = () =>{
                vm.personSoftwareUpdate = [];
                $('#formModal').modal('show');
            }

            vm.getClients = () => {
                $http.get('<?= base_url('client/getAllActive') ?>')
                    .then(function(response){
                        vm.clients = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
            }

            vm.getSoftwares = () => {
                $http.get('<?= base_url('software/getAllActive') ?>')
                    .then(function(response){
                        vm.softwares = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
            }

            $(document).on('shown.bs.modal', function (e) {
                $('#person_id').focus()
            })

            vm.getAll();
            vm.getClients();
            vm.getSoftwares();
        });
    </script>


<?= $this->endSection() ?>