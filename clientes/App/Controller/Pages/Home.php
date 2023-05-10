<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\ClientDao;
use Exception;

class Home extends Page{
    
    public static function getHome(){
        $clientDao = new ClientDao();
        $lineClient = '';

        foreach($clientDao->read('') as $client){
            $lineClient .= "<tr>
                                <td>{$client['Id_Client']}</td>
                                <td>{$client['Name']}</td>
                                <td>{$client['Email']}</td>
                                <td>{$client['TelPhone']}</td>
                                <td>{$client['Cpf']}</td>
                                <td>
                                    <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                                    <a class='btn btn-danger' href='index.php?type=delete&id={$client['Id_Client']}' data-toggle='tooltip' title='Deletar'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/>
                                            <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/>
                                        </svg>
                                    </a>
                                    <a class='btn btn-primary' href='index.php?type=update&id={$client['Id_Client']}'  data-toggle='tooltip' title='Editar'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                        </svg>    
                                    </a>
                                </div>
                                </td>
                            </tr>";
        }
        
        $content = View::render('pages/home',[
            'lineClient' => $lineClient,
        ]);

        if(isset($_GET['type'])){
            $type = $_GET['type'];
            try{
                if($type == 'create'){
                    ?>
                        <form id="background-mondal" method="post">
                            <div style="display: block" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-light">
                                            <h5 class="modal-title">Adicionar um cliente</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" autocomplete="off" name="name" id="name" placeholder="Nome do Cliente">
                                                <label for="floatingInput">Nome do Cliente</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" autocomplete="off" name="email" id="email" placeholder="E-mail do Cliente">
                                                <label for="floatingPassword">E-mail do Cliente</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" autocomplete="off" name="telphone" id="telphone" placeholder="Telefone do Cliente">
                                                <label for="floatingPassword">Telefone do Cliente</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="number"  class="form-control" autocomplete="off" name="cpf" id="cpf" placeholder="CPF do Cliente">
                                                <label for="floatingPassword">CPF do Cliente</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="btn-cancel" id="btn-cancel" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" name="btn-success" id="btn-success" class="btn btn-primary">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php

                    if(isset($_POST['btn-success'])){
                        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['telphone']) || empty($_POST['cpf'])) {
                            throw new Exception('Todos os campos são obrigatórios!', 41);
                        }
                        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            throw new Exception('O campo <b>Email</b> é inválido!', 41);
                        }
                        $client = new \App\Model\Client('', $_POST['name'], $_POST['email'], $_POST['telphone'], $_POST['cpf']);
                        $clientDao->create($client);
                        $_SESSION['messagerBar'] = ['alert' => 'success', 'messeger' => 'Cliente cadastrado com sucesso!'];
                        header('Location: index.php');
                        
                    } else if(isset($_POST['btn-cancel'])){
                        throw new Exception('Ação Cancelada!', 40);
                    }

                } else if($type == 'update'){
                    foreach($clientDao->read($_GET['id']) as $client){
                        ?>
                            <form id="background-mondal" method="post">
                                <div style="display: block" class="modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-light">
                                                <h5 class="modal-title">Atualizar dados do cliente</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" autocomplete="off" name="name" id="name" placeholder="Nome do Cliente">
                                                    <label for="floatingInput"><?php echo $client['Name'] ?></label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" autocomplete="off" name="email" id="email" placeholder="E-mail do Cliente">
                                                    <label for="floatingPassword"><?php echo $client['Email'] ?></label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" autocomplete="off" name="telphone" id="telphone" placeholder="Telefone do Cliente">
                                                    <label for="floatingPassword"><?php echo $client['TelPhone'] ?></label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" autocomplete="off" name="cpf" id="cpf" placeholder="CPF do Cliente">
                                                    <label for="floatingPassword"><?php echo $client['Cpf'] ?></label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="btn-cancel" id="btn-cancel" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" name="btn-success" id="btn-success" class="btn btn-primary">Adicionar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                    }

                    if(isset($_POST['btn-success'])){

                        $client = new \App\Model\Client($_GET['id'],
                            $_POST['name'] != '' ? $_POST['name'] : $client['Name'],
                            $_POST['email'] != '' ? $_POST['email'] : $client['Email'],
                            $_POST['telphone'] != '' ? $_POST['telphone'] : $client['TelPhone'],
                            $_POST['cpf'] != '' ? $_POST['cpf'] : $client['Cpf']
                        );
                        $clientDao->update($client);
                        header('Location: http://matheus.com/projetos/clientes/');

                    } else if(isset($_POST['btn-cancel'])){
                        throw new Exception('Ação Cancelada!', 40);
                    }

                } else if( $type == 'delete'){
                    ?>
                    <form id="background-mondal" method="post">
                        <div style="display: block"class="modal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-light">
                                        <h5 class="modal-title">Apagando o Cliente</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Você realmente deseja apagar esse cliente?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="btn-cancel" id="btn-cancel" class="btn btn-outline-secondary" data-bs-dismiss="modal">fechar</button>
                                        <button type="submit" name="btn-danger" id="btn-danger" class="btn btn-danger">Apagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php

                    if(isset($_POST['btn-danger'])){
                        $clientDao->delete($_GET['id']);
                        header('Location: index.php');
                    } else if(isset($_POST['btn-cancel'])){
                        throw new Exception('Ação cancelada!', 42);
                    }
                }
            } catch(Exception $erro){
                $_SESSION['messagerBar'] = ['alert' => 'danger', 'messeger' => $erro->getMessage()];
                header('Location: index.php');
            }
        }
        return parent::getPage($content, 'Gerenciamento de Clientes');
    }
}