# Parte A: Exercícios Teóricos de Fixação

1. **Conceituação OWASP: O que significa a sigla XSS e por que ela é classificada como uma vulnerabilidade no lado do cliente (Client-Side) que deve ser prevenida pelo Back-End ?**

*Resposta* : XSS significa Cross-Site Scripting. É uma vulnerabilidade que permite inserir códigos maliciosos em uma página. Ela ocorre no navegador do usuário, mas o Back-End deve ajudar a preveni-la tratando os dados corretamente.

2. **Reflected vs Stored: Qual é a diferença entre um ataque XSS Refletido e um XSS Gravado (Stored)? Qual dos dois apresenta maior potencial de estrago para uma empresa e por quê ?**

*Resposta* : O XSS Refletido ocorre quando o código malicioso é enviado em uma requisição e retornado pela página. O Stored é armazenado na aplicação e pode atingir vários usuários. Por isso, o Stored pode causar um impacto maior.

3. **Mecanismo de Escapamento: Explique detalhadamente a transformação que a função htmlspecialchars() realiza nos caracteres < e >. Por que o navegador não executa o código após essa transformação ?**

*Resposta* : htmlspecialchars() transforma < em &lt; e > em &gt;. Assim, o navegador entende esses caracteres como texto, e não como tags HTML, impedindo a execução do código.

4. **Flags de Proteção: Qual é a função da flag ENT_QUOTES na chamada de htmlspecialchars()? O que pode acontecer se essa flag for omitida em um campo <input value="..."> ?**

*Resposta* : ENT_QUOTES também protege aspas simples e duplas. Sem ela, um atacante poderia tentar sair do atributo value de um <input> e inserir código malicioso.

5. **Anti-Alucinação PHP: Por que não devemos utilizar o filtro FILTER_SANITIZE_STRING em projetos modernos desenvolvidos em PHP 8.3 ?**

*Resposta* : FILTER_SANITIZE_STRING foi descontinuado no PHP 8.1 e não deve ser usado em projetos modernos. Além disso, ele não é uma proteção geral contra XSS.

6. **Validação de E-mail: Qual é a diferença prática entre verificar um e-mail com empty($email) e verificar com filter_var($email, FILTER_VALIDATE_EMAIL) ?**

*Resposta* : empty($email) apenas verifica se o campo está vazio. Já filter_var($email, FILTER_VALIDATE_EMAIL) verifica se o conteúdo possui um formato válido de e-mail.

7. **Roubo de Sessão: Como um atacante pode usar uma brecha XSS para capturar o cookie de sessão de um usuário logado ?**

*Resposta* : Um atacante pode aproveitar uma falha XSS para executar um código no navegador de uma pessoa que está logada. Se o cookie da sessão estiver acessível, ele pode ser capturado e usado para tentar acessar a conta da vítima.

8. **Segurança em Camadas: Por que sanitizar na entrada (ex: com strip_tags) não elimina a necessidade de codificar na saída com htmlspecialchars() ?**

*Resposta* : Usar apenas strip_tags() não é suficiente, porque ele remove algumas tags, mas não protege todos os casos de XSS. Já o htmlspecialchars() transforma caracteres especiais em texto. Por isso, é importante validar os dados na entrada e também protegê-los na saída.