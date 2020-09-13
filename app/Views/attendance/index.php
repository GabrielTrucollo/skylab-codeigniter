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
                                href="#attendance{{attendance.attendance_id}}"
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
                                        <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModal(attendance)"><i class="far fa-edit"></i></a>
                                        <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.delete(attendance)"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr ng-repeat-end="attendance in vm.attendances | filter:vm.search" class="hide-table-padding">
                                <td colspan="10">
                                    <div id="attendance{{attendance.attendance_id}}" class="collapse in p-3">
                                        <div class="row">
                                            <div class="col-4 text-primary"><b>Usuário</b></div>
                                            <div class="col-6 text-danger"><b>Descrição do Problema</b></div>
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

        <!-- Form modal -->
        <div class="modal fade" id="formModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-lg">
                <div class="modal-content">
                    <div class="modal-c-tabs">
                        <form method="post" action="<?= base_url('attendance/save')?>">
                            <ul class="nav md-tabs tabs-2 light-blue darken-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#dadosGerais" role="tab"><i class="fas fa-headset mr-1"></i>Dados Gerais</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#eventos" role="tab"><i class="fas fa-clipboard-list mr-1"></i>Eventos</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- Dados Gerais -->
                                <div class="tab-pane fade in show active" id="dadosGerais" role="tabpanel">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="md-form col-sm-4 md-outline">
                                                <input type="text" id="attendance_id" name="attendance_id" class="form-control" readonly value="{{vm.attendance.attendance_id}}">
                                                <label class="active" for="attendance_id">Sequencial</label>
                                            </div>
                                            <div class="md-form col-sm-4 md-outline">
                                                <input type="text" id="date" name="start_date" class="form-control" value="{{vm.attendance.start_date}}">
                                                <label for="start_date">Data</label>
                                            </div>
                                            <div class="md-form col-sm-2 md-outline">
                                                <input type="text" id="time" name="start_time" class="form-control" value="{{vm.attendance.start_time}}">
                                                <label for="start_date">Hora</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select name="person_id" id="person_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar...">
                                                    <option value="" disabled selected>Pesquisa de Clientes</option>
                                                    <option
                                                            ng-repeat="client in vm.clients track by client.person_id"
                                                            value="{{client.person_id}}"
                                                            ng-selected="client.person_id == vm.attendance.person_id" >{{client.company_name}}
                                                    </option>
                                                </select>
                                                <label class="mdb-main-label">Cliente</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select name="attendance_reason_id" id="attendance_reason_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar...">
                                                    <option value="" disabled selected>Pesquisa de Motivo de Atendimento</option>
                                                    <option
                                                            ng-repeat="reason in vm.attendancesReason track by reason.attendance_reason_id"
                                                            value="{{reason.attendance_reason_id}}"
                                                            ng-selected="reason.attendance_reason_id == vm.attendance.attendance_reason_id" >{{reason.description}}
                                                    </option>
                                                </select>
                                                <label class="mdb-main-label">Motivo</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form md-outline">
                                                    <textarea type="text" id="description" name="description" class="md-textarea form-control" rows="3" cols="3">{{vm.attendance.description}}</textarea>
                                                    <label for="description">Descrição do Problema</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Eventos -->
                                <div class="tab-pane fade" id="eventos" role="tabpanel">
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                                <table id="main-table" class="table table-hover table-striped table-bordered" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>Usuário</th>
                                                        <th>Tipo</th>
                                                        <th width="170px" class="text-center">Status</th>
                                                        <th width="120px" class="text-center">Ações</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="attendanceEvent in vm.attendance.listEvents">
                                                            <td>{{ attendanceEvent.user }}</td>
                                                            <td>{{ attendanceEvent.attendance_type }}</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm m-0" ng-class="vm.getClassSituation(attendanceEvent)">
                                                                    {{ vm.getDescriptionSituation(attendanceEvent) }}
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <div class="text-center">
                                                                    <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditModalEvent(attendanceEvent)"><i class="far fa-edit"></i></a>
                                                                    <a type="button" id="remove" class="btn-floating btn-sm btn-danger" ng-click="vm.deleteEvent(attendanceEvent)"><i class="fas fa-trash"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
        angular.module('attendance', []);
        angular.module('attendance').controller('attendanceController', function($scope ,$http) {
            const vm = this;

            vm.getClassSituation = (attendance) => {
                switch (attendance.situation){
                    case null:
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
                let situation = vm.situation.find(x => x.value == attendance.situation);
                switch (situation){
                    case true:
                        return situation.description;

                    default:
                        return 'Em Espera';
                }
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

            vm.getAttendancesReason = () => {
                $http.get('<?= base_url('attendance-reason/getAllActive') ?>')
                    .then(function(response){
                        vm.attendancesReason = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
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

            vm.showEditModal = (register) => {
                $http.get('<?= base_url('attendance') ?>/' + register.attendance_id)
                    .then(function(response){
                        vm.attendance = response.data;
                        vm.attendance.start_date = moment(vm.attendance.start_date).format('DD/MM/yyyy');
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });

                $('#formModal').modal('show');
            }

            vm.showNewModal = () =>{
                vm.attendance =
                    {
                        start_date: moment(new Date()).format('DD/MM/yyyy'),
                        start_time: moment(new Date()).format('HH:mm')
                    };

                $('#formModal').modal('show');
            }

            vm.situation = [
                {value: 0, description: 'Em Espera'},
                {value: 1, description: 'Em Atendimento'},
                {value: 2, description: 'Em Desenvolvimento'},
                {value: 99, description: 'Concluído'}
            ];

            vm.getClients();
            vm.getAttendancesReason();
            vm.getAll();
        });
    </script>
<?= $this->endSection() ?>