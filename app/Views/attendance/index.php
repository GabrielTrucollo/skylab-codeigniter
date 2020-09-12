<?= $this->extend('includes/layout_logged') ?>

<?= $this->section('container') ?>
    <div ng-app="attendance" ng-controller="attendanceController as vm">

        <section>
            <h3 class="dark-grey-text font-weight-bold text-center"><i class="fas fa-headset"></i> Atendimentos</h3>
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
                    <div class="table-responsive">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="main-table" class="table table-hover table-striped table-bordered" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="80px">Sequencial</th>
                                <th>Cliente</th>
                                <th width="140px">Telefone</th>
                                <th width="170px" class="text-center">Status</th>
                                <th width="120px" class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                ng-repeat-start="attendance in vm.attendances | filter:vm.search"
                                class="accordion-toggle collapsed"
                                id="attendances"
                                data-toggle="collapse"
                                data-parent="#attendances"
                                href="#attendance1"
                            >
                                <td class="expand-button" hidden></td>
                                <td>{{ attendance.attendance_id }}</td>
                                <td>{{ attendance.person_company_name }}</td>
                                <td>{{ attendance.person_phone }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm m-0" ng-class="vm.getClassSituation(attendance)">
                                        {{ vm.getDescriptionSituation(attendance) }}
                                    </button>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModal(attendance_reason)"><i class="far fa-edit"></i></a>
                                        <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.delete(attendance_reason)"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                                <tr ng-repeat-end class="hide-table-padding">
                                    <td colspan="10">
                                        <div id="attendance{{attendance.attendance_id}}" class="collapse in p-3">
                                            <div class="row">
                                                <div class="col-4 text-primary"><b>Usuário</b></div>
                                                <div class="col-6 text-danger"><b>Problema Reportado</b></div>
                                                <div class="col-2 text-dark"><b>Data</b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 text-primary">{{attendance.event_user_name}}</div>
                                                <div class="col-6 text-danger">{{attendance.report}}</div>
                                                <div class="col-2 text-dark"><b>{{ vm.getFormatDate(attendance)}}</b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-dark"><b>Descrição</b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-dark">{{attendance.event_description}}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="<?= base_url('assets/js/angular.min.js'); ?>"></script>
    <script>
        angular.module('attendance', []);
        angular.module('attendance').controller('attendanceController', function($scope ,$http) {
            const vm = this;

            vm.getClassSituation = (attendance) => {
                switch (attendance.situation){
                    case '0':
                        return 'btn-danger';

                    case '1':
                        return 'btn-success';

                    case '2':
                        return 'btn-amber';

                    case '99':
                        return 'btn-primary';
                }
            }

            vm.getFormatDate = (attendance) => {
                return moment(attendance.event_created_at).format('DD/MM/yyyy');
            }

            vm.getDescriptionSituation = (attendance) => {
                return vm.situation.find(x => x.value == attendance.situation).description;
            }

            vm.getAll = () => {
                $http.get('<?= base_url('attendance/getAll') ?>')
                    .then(function(response){
                        vm.attendances = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
            }

            vm.situation = [
                {value: 0, description: 'Em Espera'},
                {value: 1, description: 'Em Atendimento'},
                {value: 2, description: 'Em Desenvolvimento'},
                {value: 99, description: 'Concluído'}
            ];

            vm.getAll();
        });
    </script>
<?= $this->endSection() ?>