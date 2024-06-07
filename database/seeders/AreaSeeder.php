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
            'Sistemas Operacionais',
            "Teoria da Computação",
            "Computabilidade e Modelos de Computação",
            "Linguagem Formais e Autômatos",
            "Análise de Algoritmos e Complexidade de Computação",
            "Lógicas e Semântica de Programas",
            "Matemática da Computação",
            "Matemática Simbólica",
            "Modelos Analíticos e de Simulação",
            "Metodologia e Técnicas da Computação",
            "Linguagens de Programação",
            "Processamento Gráfico (Graphics)",
            "Sistema de Computação",
            "Hardware",
            "Arquitetura de Sistemas de Computação",
            "Software Básico",
            "Teleinformática",
        ];

        foreach ($areas as $key => $value) {
            Area::updateOrCreate(['nome' => $value]);
        }
    }
}
