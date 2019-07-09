<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Event\Event;
use ArrayObject;
use Cake\Log\Log;

class FeedsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('feeds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    public function sendReceiveRequest($userToMail) {
      $email = new Email(['from' => 'julio.gomes@clicksoft.com.br', 'transport' => 'default']);

      Log::write('debug', 'email = ' . $userToMail['user_to']['email']);

      $email->template('receiverequest')
          ->viewVars(['user_to' => $userToMail['user_to'], 'user_receive_request' =>$userToMail['user_receive_request']])
          ->from(['julio.gomes@clicksoft.com.br' => 'BlinkNet'])
          ->to($userToMail['user_to']['email'])
          ->subject('BlinkNet - Receber pedido')
          ->emailFormat('html');

      Log::write('debug', $email);
      Log::write('send', $email->send());

      if ($email->send()) {

          return true;

      } else {

          return false;
      }
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
