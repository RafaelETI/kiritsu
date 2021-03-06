<?php
namespace Controller;

use Model\Agenda;

class HistoricoController
{
    private $app;

    public function __construct()
    {
        global $app;
        $this->app = $app;
    }

    public function getVisualizar()
    {
        $pagina = isset($_GET['pagina'])? $_GET['pagina']: 1;

        try {
            $agenda = new Agenda($this->app->config('config'));
            $_GET[$agenda->c[6]] = 1;
            $banco = $agenda->paginar($_GET, 'desc', 15, $pagina);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $this->app->render('historico/visualizar.php', ['app' => $this->app, 'agenda' => $agenda, 'banco' => $banco]);
    }

    public function getBuscar()
    {
        try {
            $agenda = new Agenda($this->app->config('config'));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $this->app->render('historico/buscar.php', ['app' => $this->app, 'agenda' => $agenda]);
    }

    public function getEditar($c0)
    {
        try {
            $agenda = new Agenda($this->app->config('config'));
            $a = $agenda->ler([$agenda->c[0] => $c0])->vetorizar();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $a = \Miti\Tratamento::escapar($a);

        $this->app->render('historico/editar.php', ['app' => $this->app, 'agenda' => $agenda, 'a' => $a]);
    }

    public function postEditar($c0)
    {
        try {
            $agenda = new Agenda($this->app->config('config'));
            $_POST[$agenda->c[0]] = $c0;
            $agenda->atualizar($_POST);
            
            $this->app->flash('status', 'ok');
            $this->app->flash('message', 'Sucesso ao editar a história');
        } catch (\Exception $e) {
            $this->app->flash('status', 'nok');
            $this->app->flash('message', $e->getMessage());
        }

        $this->app->redirect("/l/historico/editar/$c0");
    }

    public function getAgendar($c0)
    {
        try {
            $agenda = new Agenda($this->app->config('config'));
            $agenda->agendar([$agenda->c[0] => $c0]);
            
            $this->app->flash('status', 'ok');
            $this->app->flash('message', 'Sucesso ao reagendar a história');
        } catch (\Exception $e) {
            $this->app->flash('status', 'nok');
            $this->app->flash('message', $e->getMessage());
        }

        $this->app->redirect('/l/agenda/visualizar');
    }

    public function getExcluir($c0)
    {
        try {
            $agenda = new Agenda($this->app->config('config'));
            $agenda->deletar([$agenda->c[0] => $c0]);
            
            $this->app->flash('status', 'ok');
            $this->app->flash('message', 'Sucesso ao excluir a história');
        } catch (\Exception $e) {
            $this->app->flash('status', 'nok');
            $this->app->flash('message', $e->getMessage());
        }

        $this->app->redirect('/l/historico/visualizar');
    }
}
