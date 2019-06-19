<?php
use Migrations\AbstractSeed;

/**
 * BranchOfActivities seed.
 */
class BranchOfActivitiesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '60',
                'name' => 'Academia',
            ],
            [
                'id' => '48',
                'name' => 'Autopeças',
            ],
            [
                'id' => '44',
                'name' => 'Bar ou Lanchonete',
            ],
            [
                'id' => '51',
                'name' => 'Barbearia',
            ],
            [
                'id' => '66',
                'name' => 'Brinquedos',
            ],
            [
                'id' => '65',
                'name' => 'Calçados',
            ],
            [
                'id' => '55',
                'name' => 'Casa de Festas',
            ],
            [
                'id' => '57',
                'name' => 'Celulares',
            ],
            [
                'id' => '56',
                'name' => 'Cesta Básica',
            ],
            [
                'id' => '61',
                'name' => 'Clínica médica',
            ],
            [
                'id' => '64',
                'name' => 'Decoração',
            ],
            [
                'id' => '41',
                'name' => 'Delicatessen',
            ],
            [
                'id' => '45',
                'name' => 'Distribuidor de bebidas',
            ],
            [
                'id' => '53',
                'name' => 'Distribuidor de medicamentos',
            ],
            [
                'id' => '69',
                'name' => 'Eletrônicos Áudio e Video',
            ],
            [
                'id' => '49',
                'name' => 'Escola',
            ],
            [
                'id' => '52',
                'name' => 'Farmácia ou Drogaria',
            ],
            [
                'id' => '68',
                'name' => 'Games',
            ],
            [
                'id' => '59',
                'name' => 'Gráfica',
            ],
            [
                'id' => '67',
                'name' => 'Hobbies',
            ],
            [
                'id' => '54',
                'name' => 'Informática',
            ],
            [
                'id' => '70',
                'name' => 'Instrumentos Musicais',
            ],
            [
                'id' => '74',
                'name' => 'Lavanderia',
            ],
            [
                'id' => '40',
                'name' => 'Loja de carnes',
            ],
            [
                'id' => '73',
                'name' => 'Loja de Conveniência',
            ],
            [
                'id' => '46',
                'name' => 'Material de Construção',
            ],
            [
                'id' => '58',
                'name' => 'Material Esportivo',
            ],
            [
                'id' => '38',
                'name' => 'Mercado ou Mercearia',
            ],
            [
                'id' => '47',
                'name' => 'Oficina Mecânica',
            ],
            [
                'id' => '39',
                'name' => 'Padaria',
            ],
            [
                'id' => '42',
                'name' => 'Papelaria',
            ],
            [
                'id' => '71',
                'name' => 'Pet Shop',
            ],
            [
                'id' => '75',
                'name' => 'Posto de combustível',
            ],
            [
                'id' => '43',
                'name' => 'Restaurante',
            ],
            [
                'id' => '62',
                'name' => 'Roupas Femininas',
            ],
            [
                'id' => '63',
                'name' => 'Roupas Masculinas',
            ],
            [
                'id' => '50',
                'name' => 'Salão de Beleza',
            ],
            [
                'id' => '37',
                'name' => 'Supermercado',
            ],
            [
                'id' => '72',
                'name' => 'Veterinária',
            ],
        ];

        $table = $this->table('branch_of_activities');
        $table->insert($data)->save();
    }
}
