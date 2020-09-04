

<div ng-app="users" ng-controller="usersController as vm">
    <!-- Section: Basic examples -->
    <section>
        <h3 class="my-4 dark-grey-text font-weight-bold text-center"><i class="fas fa-user"></i> Cadastro de Usuários</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-10">
                        <label>Pesquisar</label>
                        <input type="text" class="form-control" ng-model="vm.search">
                    </div>
                    <div class="col-sm-2 text-right mt-4">
                        <a type="button" class="btn-floating btn-info" href="<?= base_url('user/new') ?>"  data-toggle="tooltip" title="Novo cadastro"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table id="main-table" class="table table-hover table-striped table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="80px">Sequencial</th>
                                <th>Nome</th>
                                <th width="140px">CPF</th>
                                <th width="100px" class="text-center">Permissão</th>
                                <th width="120px" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="user in vm.users | filter:vm.search">
                            <td>{{ user.user_id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.doc_cpf}}</td>
                            <td>
                                <button type="button" class="btn btn-sm m-0" ng-class="user.user_administrator == 1 ? 'btn-danger' : 'btn-info'">
                                    {{ user.user_administrator == 1 ? 'Administrador' : 'Comum' }}
                                </button>
                            </td>
                            <td>
                                <div class="text-center">
                                <a type="button" class="btn-floating btn-sm btn-amber" href="<?= base_url('user/new') ?>/"><i class="far fa-edit"></i></a>
                                <a type="button" class="btn-floating btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
    angular.module('users', []);
    angular.module('users').controller('usersController', function($scope ,$http) {
        const vm = this;
        $http.get('<?= base_url('user/getAll') ?>')
            .then(function(response){
                vm.users = response.data;
            })
            .catch(function(error){
                toastr.error(error);
            });
    });
</script>
