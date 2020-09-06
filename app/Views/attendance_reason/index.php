<?= $this->extend('includes/layout_logged') ?>

<?= $this->section('container') ?>
<div ng-app="attendance-reason" ng-controller="attendance-reasonController as vm">
    <!-- Section: Basic examples -->
    <section>
        <h3 class="my-4 dark-grey-text font-weight-bold text-center"><i class="fas fa-book"></i> Cadastro de Motivos de Atendimento</h3>
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
                                <th>Descrição</th>
                                <th width="140px">Status</th>
                                <th width="120px" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="attendance_reason in vm.attendance_reasons | filter:vm.search">
                            <td>{{ attendance_reason.attendance_reason_id }}</td>
                            <td>{{ attendance_reason.description }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm m-0" ng-class="attendance_reason.status == 1 ? 'btn-danger' : 'btn-info'">
                                    {{ attendance_reason.status == 1 ? 'Inativo' : 'Ativo' }}
                                </button>
                            </td>
                            <td>
                                <div class="text-center">
                                <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModal(attendance_reason)"><i class="far fa-edit"></i></a>
                                <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.delete(attendance_reason)"><i class="fas fa-trash"></i></a>
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
                    <h5 class="heading lead"><i class="fa fa-book"></i> Cadastro de Motivos de Atendimento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <form method="post" action="<?= base_url('attendance-reason/save')?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="md-form col-sm-4">
                                <input type="text" id="attendance_reason_id" name="attendance_reason_id" class="form-control" readonly value="{{vm.attendance_reason.attendance_reason_id}}">
                                <label for="attendance_reason_id">Sequencial</label>
                            </div>
                            <div class="col-sm-4">
                                <select id="status" name="status" class="browser-default custom-select" required>
                                    <option
                                            ng-repeat="status in vm.status track by status.value"
                                            value="{{status.value}}"
                                            ng-selected="status.value == vm.attendance_reason.status" >{{status.description}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="md-form col-sm-12">
                                <input type="text" id="description" name="description" maxlength="50" class="form-control" value="{{vm.attendance_reason.description}}" required>
                                <label for="description">Nome</label>
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
    angular.module('attendance-reason', []);
    angular.module('attendance-reason').controller('attendance-reasonController', function($scope ,$http) {
        const vm = this;

        vm.getAll = () => {
            $http.get('<?= base_url('attendance-reason/getAll') ?>')
                .then(function(response){
                    vm.attendance_reasons = response.data;
                })
                .catch(function(error){
                    toastr.error(error);
                });
        }

        vm.delete = (register) => {
            $http.delete('<?= base_url('attendance-reason') ?>/' + register.attendance_reason_id)
                .then(function(response){
                    toastr.success('Registro excluído com sucesso!');
                    vm.getAll();
                })
                .catch(function(error){
                    toastr.error(error.data);
                });
        }

        vm.showEditModal = (register) => {
            $http.get('<?= base_url('attendance-reason') ?>/' + register.attendance_reason_id)
                .then(function(response){
                    vm.attendance_reason = response.data;
                })
                .catch(function(error){
                    toastr.error(error);
                });

            $('#formModal').modal('show');
        }

        vm.showNewModal = () =>{
            vm.attendance_reason = [];
            $('#formModal').modal('show');
        }

        $(document).on('shown.bs.modal', function (e) {
            $('#name').focus()
        })

        vm.getAll();

        vm.status = [
            {value: 0, description: 'Ativo'},
            {value: 1, description: 'Inativo'}
        ];
    });
</script>

<?= $this->endSection() ?>
