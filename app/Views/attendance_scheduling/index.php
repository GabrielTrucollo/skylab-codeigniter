<?= $this->extend('includes/layout_logged') ?>
<?= $this->section('container') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/main.min.css')?>">

<div ng-app="attendance-scheduling" ng-controller="attendance-schedulingController as vm">
    <section>
        <h3 class="dark-grey-text font-weight-bold text-center"><i class="fas fa-calendar-alt"></i> Agendamentos</h3>
        <div class="card">
            <div class="card-body">
                <div id='calendar'></div>
        </div>
    </section>

    <!-- Form modal -->
    <div class="modal fade" id="formModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal modal-lg">
            <div class="modal-content">
                <div class="modal-header info-color-dark text-white">
                    <h5 class="heading lead"><i class="fa fa-calendar-alt"></i> Agendamentos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('attendance-scheduling/save')?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="md-form col-sm-4 md-outline">
                                <input type="text" id="attendance_scheduling_id" name="attendance_scheduling_id" class="form-control" readonly value="{{vm.attendance_scheduling.attendance_scheduling_id}}">
                                <label for="attendance_scheduling_id">Sequencial</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select name="person_id" id="person_id" class="select-wrapper mdb-select colorful-select dropdown-primary md-form" searchable="Pesquisar...">
                                    <option value="" disabled selected>Pesquisa de Clientes</option>
                                    <option
                                            ng-repeat="client in vm.clients track by client.person_id"
                                            value="{{client.person_id}}"
                                            ng-selected="client.person_id == vm.attendance_scheduling.person_id" >{{client.company_name}}
                                    </option>
                                </select>
                                <label class="mdb-main-label">Cliente</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="md-form col-sm-3 md-outline">
                                <input type="text" id="date1" name="start_date" class="form-control" value="{{vm.attendance_scheduling.start_date}}" required>
                                <label for="start_date">Data de Início</label>
                            </div>
                            <div class="md-form col-sm-2 md-outline">
                                <input type="text" id="time1" name="start_hour" class="form-control" value="{{vm.attendance_scheduling.start_hour}}" required>
                                <label for="start_date">Hora</label>
                            </div>
                            <div class="md-form col-sm-3 md-outline">
                                <input type="text" id="date2" name="end_date" class="form-control" value="{{vm.attendance_scheduling.end_date}}" required>
                                <label for="end_date">Data de Encerramento</label>
                            </div>
                            <div class="md-form col-sm-2 md-outline">
                                <input type="text" id="time2" name="end_hour" class="form-control" value="{{vm.attendance_scheduling.end_hour}}" required>
                                <label for="end_hour">Hora</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="md-form md-outline">
                                    <textarea type="text" id="reason" name="reason" class="md-textarea form-control" rows="3" cols="3" required>{{vm.attendance_scheduling.reason}}</textarea>
                                    <label for="reason">Motivo</label>
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
</div>

<script type="text/javascript" src="<?=base_url('assets/js/main.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/locales/pt-br.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/angular.min.js'); ?>"></script>
<script>
    angular.module('attendance-scheduling', []);
    angular.module('attendance-scheduling').controller('attendance-schedulingController', function($scope ,$http) {
        const vm = this;
        vm.getClients = () => {
            $http.get('<?= base_url('client/getAllActive') ?>')
                .then(function(response){
                    vm.clients = response.data;
                })
                .catch(function(error){
                    toastr.error(error);
                });
        }

        // Initialize calendar
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');

            // Get all
            $http.get('<?= base_url('attendance-scheduling/getAll') ?>')
                .then(function(response){
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        editable: true,
                        selectable: true,
                        allDaySlot: true,
                        events: response.data,
                        select: function(event) {
                            $http.get('<?= base_url('attendance-scheduling/new') ?>')
                                .then(function(response){
                                    vm.attendance_scheduling = response.data;
                                    vm.attendance_scheduling.start_date = moment(event.start).format('DD/MM/yyyy');
                                    vm.attendance_scheduling.start_hour = moment(new Date()).format('HH:mm');
                                    vm.attendance_scheduling.end_date = moment(event.end).format('DD/MM/yyyy');
                                    vm.attendance_scheduling.end_hour = moment(new Date().setHours(1, 0, 0, 0)).format('HH:mm');
                                })
                                .catch(function(error){
                                    toastr.error(error);
                                });

                            $('#formModal').modal('show');
                        },
                        eventClick: function(event){
                            $http.get('<?= base_url('attendance-scheduling') ?>/' + event.event.id)
                                .then(function(response){
                                    vm.attendance_scheduling = response.data;
                                    vm.attendance_scheduling.start_date = moment(vm.attendance_scheduling.start_date).format('DD/MM/yyyy');
                                    vm.attendance_scheduling.end_date = moment(vm.attendance_scheduling.end_date).format('DD/MM/yyyy');
                                })
                                .catch(function(error){
                                    toastr.error(error);
                                });

                            $('#formModal').modal('show');
                        },
                        eventDrop: function(event) {
                             if(!confirm("A data do evento será alterada, tem certeza que deseja continuar?")){
                                 event.revert();
                                 return;
                             }

                            $http.get('<?= base_url('attendance-scheduling') ?>/' + event.event.id)
                                .then(function(response){
                                    vm.attendance_scheduling = response.data;
                                    vm.attendance_scheduling.start_date = moment(event.event.start).format('DD/MM/yyyy');
                                    vm.attendance_scheduling.end_date = moment(event.event.start).format('DD/MM/yyyy');
                                })
                                .catch(function(error){
                                    toastr.error(error);
                                });

                            $('#formModal').modal('show');
                        }
                    });

                    vm.getClients();
                    calendar.render();
                    calendar.setOption('locale', 'pt-br');
                })
                .catch(function(error){
                    toastr.error(error);
                });
        });
    });
</script>
<?= $this->endSection() ?>