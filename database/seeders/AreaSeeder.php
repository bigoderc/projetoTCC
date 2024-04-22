<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $areas = [
            'Agricultura Digital',
            'Algoritmos',
            'Análise e Projeto de Sistemas',
            'Aprendizado de Máquina',
            'Avaliação de Desempenho de Sistemas',
            'Banco de Dados',
            'Desenvolvimento para Dispositivos Móveis',
            'Desenvolvimento Multiplataforma',
            'Desenvolvimento Web',
            'DevOps',
            'E-Learning',
            'Empreendedorismo',
            'Engenharia de Software',
            'Estatística',
            'Estrutura de Dados',
            'Gestão de Tecnologia da Informação',
            'Inclusão Digital',
            'Interface Homem Máquina',
            'Informática Acessível',
            'Informática e Sociedade',
            'Inglês',
            'Libras',
            'Lógica de Programação',
            'Marketing Digital',
            'Matemática',
            'Metodologia da Pesquisa Científica',
            'Organização e Arquitetura de Computadores',
            'Programação Concorrente',
            'Programação Orientada a Objetos',
            'Planejamento e Gerência de Projetos',
            'Redes de Computadores',
            'Relações Interpessoais',
            'Responsabilidade Socioambiental em TI',
            'Segurança',
            'Sistemas Distribuídos',
            'Sistemas Embarcados',
            'Sistemas de Informação',
            'Sistemas Operacionais'
        ];

        foreach($areas as $key => $value){
            Area::updateOrCreate(['nome'=>$value]);
        }
    }
}
