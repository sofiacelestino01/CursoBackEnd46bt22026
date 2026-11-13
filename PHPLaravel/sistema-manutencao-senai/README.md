# Sistema de Manutenção do SENAI - TPM Indutrial

Objetivo: Para consolidar os conceitos de Model, Controller e Blade

## Cenário do Projeto

Na indústria paradas não planejadas de máruinas críticas custam milhares de reais por minutos ou horas. 
A aplicação deve gerenciar:
1. **Equipamentos Industriais** : tag de patrimônio, setor fabril, criticidade (Alta , Média, Baixa) e status operacional
2. **Ordens de Serviço(O.S)** : Tipo de manutenção(Preventiva, Corretiva, Preditiva), prioridade, técnico responsável, data limite e status (ABERTA, EM_ANDAMENTO, CONCLUIDA)
3. **Painel de Indicadores(Dashboard)**: Calcular em tempo real, equipamentos em operação, ordens de emergência e taca de conformidade de manutenção

## Configuração do Ambiente de Trabalho e Desenvolvimento

- Configurar o .env

1. APP_KEY
2. Informações da Base de Dados (Banco de Dados)

- Criar o Banco de Dados

CREATE DATABASE senai_manutencao;

## Criar os Models

php artisan make:model NomeDoModelo -m

Equipamento (tag, nome, setor, criticidade, status)

OrdemServico (codigo, titulo, (int)equipamentoId, tipo, prioridade, status, tecnico, dataAbertura, prazoLimite)