# Documentação de Requisitos - Wallet

## Descrição
A aplicação de carteira digital tem como objetivo principal auxiliar o usuário no controle de seus gastos e ganhos financeiros. A plataforma permite a criação de transações (despesas e receitas), visualização de dados de forma gráfica e categorizada, e gestão completa das informações do usuário.

---

## Tecnologias Utilizadas
- **Backend**: Laravel 11+
- **Banco de Dados**: PostgreSQL

---

## Funcionalidades Principais

### 1. Autenticação de Usuário
#### Fazer Login
- Permite que o usuário acesse sua conta utilizando **e-mail** e **senha**.
- Validação de campos obrigatórios.
- Mensagens de erro para credenciais inválidas.

#### Cadastro de Usuário
- Criação de conta por meio de **e-mail**, **nome** e **senha**.
- Confirmação de senha no momento do cadastro.
- Validação de e-mail único.

---

### 2. Dashboard
- Exibe um **gráfico de pizza** com as despesas agrupadas por categoria.
- Informações exibidas:
  - Percentual de cada categoria de despesa.
  - Total gasto por categoria.
  - Total geral de despesas.
- Atualização em tempo real ao criar/alterar/excluir transações.

---

### 3. CRUD de Transações
#### Tipos de Transações
- **Receitas**: Registros de ganhos financeiros.
- **Despesas**: Registros de gastos financeiros.

#### Operações Permitidas
- **Criar**: Adicionar uma nova transação com as seguintes informações:
  - Tipo: Receita ou Despesa.
  - Categoria: Ex.: Alimentação, Lazer, Transporte, etc.
  - Valor: Em moeda corrente.
  - Data da transação.
  - Descrição (opcional).
- **Visualizar**: Listagem de todas as transações do usuário
  - Data
  - Tipo de transação.
  - Categoria.
  - Valor
- **Editar**: Atualizar informações de uma transação existente.
- **Excluir**: Remover uma transação.

---

##### 4. Configurações
 - Cadastrar uma nova categoria. **Cada usuário pode ter somente 10 categorias**

## Regras de Negócio
- O usuário deve estar autenticado para acessar o dashboard e o CRUD de transações.
- O valor da transação deve ser positivo.
- Cada transação deve pertencer a uma categoria pré-definida ou personalizada pelo usuário.
- Não é permitido excluir transações relacionadas a períodos de fechamento contábil.

---

## Pendências

- [X] Desenvolver filtros dinâmicos para a listagem de transações.
- [X] Implementar CRUD das transações.
- [ ] Implementar testes.
- [ ] Implementar relatórios.
- [ ] Implementar API para comunicação do APP.
- [X] Implementar alteração de foto de perfil na aba de configurações.
- [ ] Ajustar responsividade do sistema.

