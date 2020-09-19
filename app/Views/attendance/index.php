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
                                <th width="190px" class="text-center">Status</th>
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
                                    <button type="button" class="btn btn-sm m-0" ng-class="vm.getClassSituation(attendance.attendance_event)">
                                        {{ vm.getDescriptionSituation(attendance.attendance_event) }}
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
                                            <div class="col-4 text-primary">{{attendance.attendance_event.user}}</div>
                                            <div class="col-6 text-danger">{{attendance.report}}</div>
                                            <div class="col-2 text-dark"><b>{{ vm.getFormatDate(attendance.start_date)}}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-dark"><b>Descrição</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-dark">{{attendance.attendance_event.description}}</div>
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
                                        <div class="col-s2 text-right">
                                            <a type="button" class="btn-floating btn-info" ng-click="vm.showNewEventModal(vm.attendance)"><i class="fas fa-plus"></i></a>
                                        </div>
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
                                                                    <a type="button" class="btn-floating btn-sm btn-amber" ng-click="vm.showEditEventModal(attendanceEvent)"><i class="far fa-edit"></i></a>
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
                                    <div class="text-left">
                                        <button type="button" class="btn btn-dark" ng-click="vm.showTransferModal(vm.attendance)"><i></i>Transferir</button>
                                        <button type="button" class="btn btn-indigo" ng-click="vm.showFinishModal(vm.attendance)"><i></i>Concluir</button>
                                    </div>
                                    <div class="text-right">
                                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-info">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form event modal -->
        <div class="modal fade" id="formEventModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-lg">
                <div class="modal-content">
                    <div class="modal-header info-color-dark text-white">
                        <h5 class="heading lead"><i class="fas fa-clipboard-list"></i> Lançamento de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('attendance-event/save')?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="md-form col-sm-4 md-outline">
                                    <input type="text" id="attendance_event_id" name="attendance_event_id" class="form-control" readonly value="{{vm.attendanceEvent.attendance_event_id}}">
                                    <label class="active" for="attendance_event_id">Sequencial</label>
                                    <input type="text" id="attendance_id_event" name="attendance_id" class="form-control" readonly hidden value="{{vm.attendanceEvent.attendance_id}}">
                                </div>
                                <div class="md-form col-sm-4 md-outline">
                                    <input type="text" id="date1" name="start_date" class="form-control" value="{{vm.attendanceEvent.start_date}}" required>
                                    <label for="start_date">Data</label>
                                </div>
                                <div class="md-form col-sm-2 md-outline">
                                    <input type="text" id="time1" name="start_time" class="form-control" value="{{vm.attendanceEvent.start_time}}" required>
                                    <label for="start_date">Hora</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <select name="situation" id="situation" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar..." required>
                                        <option
                                                ng-repeat="situation in vm.situation track by situation.value"
                                                value="{{situation.value}}"
                                                ng-selected="situation.value == vm.attendanceReason.situation" >{{situation.description}}
                                        </option>
                                    </select>
                                    <label class="mdb-main-label">Status</label>
                                </div>
                                <div class="col-sm-6">
                                    <select name="attendance_type_id" id="attendance_type_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar..." required>
                                        <option
                                                ng-repeat="attendanceType in vm.attendancesType track by attendanceType.attendance_type_id"
                                                value="{{attendanceType.attendance_type_id}}"
                                                ng-selected="attendanceType.attendance_type_id == vm.attendanceReason.attendance_type_id" >{{attendanceType.description}}
                                        </option>
                                    </select>
                                    <label class="mdb-main-label">Tipo</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="md-form md-outline">
                                        <textarea type="text" id="description_event" name="description" class="md-textarea form-control" rows="3" cols="3" required>{{vm.attendanceEvent.description}}</textarea>
                                        <label for="description_event">Descrição</label>
                                    </div>
                                </div>
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

        <!-- Form finish attendance modal -->
        <div class="modal fade" id="formFinishAttendance" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-lg">
                <div class="modal-content">
                    <div class="modal-header info-color-dark text-white">
                        <h5 class="heading lead"><i class="fas fa-clipboard-list"></i> Conclusão de Atendimento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('attendance/finish')?>">
                        <div class="modal-body">
                            <input type="text" id="attendance_id_finish" name="attendance_id" class="form-control" readonly hidden value="{{vm.attendanceFinish.attendance_id}}">
                            <div class="row">
                                <div class="md-form col-sm-4 md-outline">
                                    <input type="text" id="date2" name="end_date" class="form-control" value="{{vm.attendanceFinish.end_date}}" required>
                                    <label for="start_date">Data</label>
                                </div>
                                <div class="md-form col-sm-2 md-outline">
                                    <input type="text" id="time2" name="end_time" class="form-control" value="{{vm.attendanceFinish.end_time}}" required>
                                    <label for="start_date">Hora</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-info">Concluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form transfer user attendance modal -->
        <div class="modal fade" id="formTransferAttendance" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-lg">
                <div class="modal-content">
                    <div class="modal-header info-color-dark text-white">
                        <h5 class="heading lead"><i class="fas fa-clipboard-list"></i> Transferir Atendimento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('attendance/transferUser')?>">
                        <div class="modal-body">
                            <input type="text" id="attendance_id_transfer" name="attendance_id" class="form-control" readonly hidden value="{{vm.attendanceTransfer.attendance_id}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <select name="user_id" id="user_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar...">
                                        <option value="" disabled selected>Pesquisa de Usuário</option>
                                        <option
                                                ng-repeat="user in vm.users track by user.user_id"
                                                value="{{user.user_id}}">{{user.name}}
                                        </option>
                                    </select>
                                    <label class="mdb-main-label">Usuário</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-info">Transferir</button>
                        </div>
                    </form>
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
                switch (attendance?.situation){
                    case '1':
                        return 'btn-success';

                    case '2':
                        return 'btn-amber';

                    case '99':
                        return 'btn-primary';

                    case null:
                    case '0':
                    default:
                        return 'btn-danger';
                }
            }

            vm.getFormatDate = (date) => {
                if(!date){
                    return 'Sem Eventos';
                }

                return moment(date).format('DD/MM/yyyy');
            }

            vm.getDescriptionSituation = (attendance) => {
                var situation = vm.situation.find(x => x.value == attendance?.situation);
                switch (!situation){
                    case true:
                        return 'Em Espera';

                    default:
                        return situation.description;
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

            vm.getUsers = () => {
                $http.get('<?= base_url('user/getAllActive') ?>')
                    .then(function(response){
                        vm.users = response.data;
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });
            }

            vm.getAttendancesType = () => {
                $http.get('<?= base_url('attendance-type/getAllActive') ?>')
                    .then(function(response){
                        vm.attendancesType = response.data;
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

                vm.getAttendancesReason();
                vm.getClients();
                $('#formModal').modal('show');
            }

            vm.showNewEventModal = (register)  => {
                vm.attendanceEvent =
                    {
                        attendance_id: register.attendance_id,
                        start_date: moment(new Date()).format('DD/MM/yyyy'),
                        start_time: moment(new Date()).format('HH:mm'),
                    };

                $('#formEventModal').modal('show');
            }

            vm.showEditEventModal = (register) => {
                $http.get('<?= base_url('attendance-event') ?>/' + register.attendance_event_id)
                    .then(function(response){
                        vm.attendanceEvent = response.data;
                        vm.attendanceEvent.start_date = moment(vm.attendanceEvent.start_date).format('DD/MM/yyyy');
                    })
                    .catch(function(error){
                        toastr.error(error);
                    });

                $('#formEventModal').modal('show');
            }

            vm.showFinishModal = (register) => {
                vm.attendanceFinish =
                    {
                        attendance_id: register.attendance_id,
                        end_date: moment(new Date()).format('DD/MM/yyyy'),
                        end_time: moment(new Date()).format('HH:mm'),
                    };

                $('#formFinishAttendance').modal('show');
            }

            vm.showNewModal = () => {
                vm.attendance =
                    {
                        start_date: moment(new Date()).format('DD/MM/yyyy'),
                        start_time: moment(new Date()).format('HH:mm')
                    };

                vm.getClients();
                vm.getAttendancesReason();
                $('#formModal').modal('show');
            }

            vm.showTransferModal = (register) => {
                vm.attendanceTransfer = {
                    attendance_id: register.attendance_id,
                }

                $('#formTransferAttendance').modal('show');
            }

            vm.delete = (register) => {
                $http.delete('<?= base_url('attendance') ?>/' + register.attendance_id)
                    .then(function(response){
                        toastr.success('Registro excluído com sucesso!');
                    })
                    .catch(function(error){
                        toastr.error(error.data);
                    });
            }

            vm.deleteEvent = (register) => {
                $http.delete('<?= base_url('attendance-event') ?>/' + register.attendance_event_id)
                    .then(function(response){
                        toastr.success('Registro excluído com sucesso!');
                        $('#formModal').modal('hide');
                    })
                    .catch(function(error){
                        toastr.error(error.data);
                    });
            }

            vm.situation = [
                {value: 0, description: 'Em Espera'},
                {value: 1, description: 'Em Atendimento'},
                {value: 2, description: 'Em Desenvolvimento'},
                {value: 99, description: 'Concluído'}
            ];

            $(document).on('shown.bs.modal', function (e) {
                $('#person_id').focus()
            });

            vm.getAttendancesType();
            vm.getUsers();
            vm.getAll();
        });
    </script>
<?= $this->endSection() ?>