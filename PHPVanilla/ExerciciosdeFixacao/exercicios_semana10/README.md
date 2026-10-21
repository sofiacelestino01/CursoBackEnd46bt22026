## Parte A: Exercícios Teóricos de Fixação

1. **Protocolo Stateless: O que significa afirmar que o protocolo HTTP é "stateless" e por que o mecanismo de cookies/sessões é necessário para aplicações modernas?**

**Resposta**: O HTTP é considerado stateless porque não guarda automaticamente informações das requisições anteriores. Os cookies e as sessões permitem que a aplicação reconheça o usuário entre diferentes requisições, mantendo informações como login e preferências.

2. **Cookies vs. Sessões: Qual é a diferença entre os dados armazenados em um cookie e os dados mantidos no array superglobal $_SESSION? Qual dos dois apresenta maior segurança para informações confidenciais?**

**Resposta**: Os cookies armazenam informações no navegador do usuário, enquanto os dados de `$_SESSION` ficam armazenados no servidor. As sessões são mais seguras para informações confidenciais, pois os dados não ficam diretamente expostos no navegador. Mesmo assim, é importante proteger o identificador da sessão.

3. **A Flag HttpOnly: Explique detalhadamente como a configuração httponly => true impede o sequestro de sessão (Session Hijacking) mesmo se a aplicação possuir uma vulnerabilidade de Cross-Site Scripting (XSS).**

**Resposta**: A configuração `httponly => true` impede que scripts JavaScript acessem diretamente o cookie por meio de `document.cookie`. Isso dificulta o roubo do identificador da sessão em ataques XSS. Porém, não elimina completamente o risco, pois um script malicioso ainda pode realizar ações em nome do usuário dentro da página vulnerável.

4. **A Flag SameSite: Qual é a finalidade do atributo SameSite=Lax em cookies e contra qual tipo de ataque ele atua?**

**Resposta**: O atributo `SameSite=Lax` controla quando o navegador envia cookies em requisições iniciadas por outros sites. Ele ajuda a proteger contra ataques CSRF (Cross-Site Request Forgery), nos quais um site malicioso tenta fazer o navegador executar uma ação autenticada em outro site.

5. **Ataque de Fixação de Sessão: O que é o ataque de Session Fixation e por que é mandatório executar session_regenerate_id(true) imediatamente após o login do usuário?**

**Resposta**: O Session Fixation acontece quando um invasor tenta fazer a vítima utilizar um identificador de sessão conhecido por ele. Após um login bem-sucedido, devemos executar `session_regenerate_id(true)` para gerar um novo identificador e solicitar a remoção do anterior, reduzindo o risco de reutilização da sessão antiga pelo invasor.

6. **MD5 e Rainbow Tables: Por que é considerado negligência técnica armazenar senhas com algoritmos rápidos como MD5 ou SHA256? Como as Rainbow Tables operam contra esses hashes?**

**Resposta**: MD5 e SHA-256 são algoritmos rápidos, permitindo testar muitas senhas por segundo durante um ataque de força bruta. As Rainbow Tables são tabelas pré-computadas que relacionam hashes a possíveis senhas, facilitando a descoberta de senhas em determinadas situações. Por isso, devemos utilizar algoritmos próprios para senhas, como Argon2id ou Bcrypt.

7. **O Papel do Salt: O que é o Salt criptográfico e por que ele garante que dois usuários com a mesma senha possuam hashes completamente distintos no banco de dados?**

**Resposta**: O salt é um valor aleatório utilizado durante a geração do hash da senha. Ele faz com que usuários com a mesma senha normalmente tenham hashes diferentes, dificultando a identificação de senhas iguais por meio da comparação direta dos hashes. O PHP gera e armazena automaticamente o salt necessário quando utilizamos `password_hash()`.

8. **Argon2id vs Bcrypt: Por que o algoritmo Argon2id é considerado superior ao Bcrypt na proteção contra ataques de força bruta realizados por placas de vídeo (GPUs) e circuitos ASIC?**

**Resposta**: O Argon2id permite configurar o consumo de memória e o custo de processamento, dificultando ataques de força bruta realizados com GPUs e circuitos ASIC. O Bcrypt também é um algoritmo seguro quando configurado corretamente, mas não possui a mesma flexibilidade de resistência baseada em memória do Argon2id.

9. **Timing Attacks: Por que a verificação de senhas deve ser feita com password_verify() em vez do operador de comparação comum ===?**

**Resposta**: A função `password_verify()` foi desenvolvida para verificar se uma senha corresponde ao hash armazenado no banco de dados. O operador `===` apenas compara valores e não substitui esse processo de verificação. Além disso, `password_verify()` realiza a comparação de maneira apropriada para a verificação de senhas, reduzindo riscos relacionados a ataques de temporização.