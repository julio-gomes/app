<div class="container-user">
  <legend><?='Listagem de usuários'?></legend>
</div>
<div class="container-list">
  <div class="row rm-form-group-margin">
      <div class="col-md-6">
          <!-- <?=
            $this->Html->link('Exportar Usuários',
            ['controller' => 'home', 'action' => 'allUsersReport'],
            ['class' => 'link-btn', 'style'=>'display: inline-block; float: left;']);
          ?> -->
          <?php $options =[
            ''=>'Selecione um tipo de usuário',
            'Comprador'=>'Comprador',
            'Vendedor'=>'Vendedor'
          ];?>
          <label>Exportar Usuários: &nbsp;</label>
          <?=$this->Form->select('usersReport', $options, [
            'class'=>'selectUsersReport',
            'id'=>'usersReport'
          ]);?>
      </div>

      <div class="col-md-6">
        <?=$this->Form->create('search', ['class' => 'search-container', 'type' => 'get', 'valueSources' => 'query'])?>
        <div class="inline-label">
          <label>Nome: &nbsp;</label>
          <input name="name" type="text" id="UserUsername" />
        </div>
        <div class="inline-label">
          <label>E-mail: &nbsp;</label>
          <input name="email" type="text" id="UserEmail" />
        </div>
        </br></br>
        &nbsp;&nbsp;
        <button class="btn btn-link" type="submit">Filtrar</button>
        <?=$this->Html->link('Limpar filtro', ['controller' => 'Home', 'action' => 'index'], ['class' => 'link-btn']);?>
      </div>
  </div>
  <br><br>

  <div class="">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nome completo</th>
                <th>E-mail</th>
                <th>Celular</th>
                <th>Tipo</th>
                <!-- <th>Região de atuação</th> -->
            </tr>
        </thead>
        <tbody>
          <?php if ($users->count() == 0) : ?>
              <tr style="border-bottom: none;">
                  <td colspan="6" style="text-align: center;color: #8888;">Nenhum registro encontrado.</td>
              </tr>
          <?php endif;?>

          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= $user->name?></td>
              <td><?= $user->email?></td>
              <td><?= telephone($user->cellphone)?></td>
              <?php if ( $user->person_seller && $user->person_buyer ) : ?>

                <td>Comprador/Vendedor</td>

                <?php elseif ($user->person_seller) : ?>

                  <td><?= $user->person_seller['type'] == "seller" ? "Vendedor" :"Comprador";?></td>

                <?php elseif ($user->person_buyer) : ?>

                  <td><?= $user->person_buyer['type'] == "buyer" ? "Comprador" :"Vendedor";?></td>

                <?php else :?>

                  <td></td>

              <?php endif;?>
            </tr>
          <?php endforeach;?>

        </tbody>
    </table>
    <div class="paginator">
      <center>
        <ul class="pagination">
            <?=$this->Paginator->prev('&laquo; ' . __('Anterior'), ['escape' => false])?>
            <?=$this->Paginator->numbers(['escape' => false])?>
            <?=$this->Paginator->next(__('Próximo') . ' &raquo;', ['escape' => false])?>
        </ul>
      </center>
    </div>
  </div>
</div>

<?php
function telephone($number){
    $number="(".substr($number,0,2).") ".substr($number,2,-4)."-".substr($number,-4);
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    return $number;
}
?>
