# COMO RODAR O PROJETO — GUIA PARA INICIANTE

Você **não precisa saber programar**. Só siga os passos na ordem.

O projeto tem duas partes:

- **Servidor** (roda no PC): guarda os dados e as fotos.
- **Aplicativo** (roda no celular): mostra o catálogo e os formulários.

Para o celular funcionar, o servidor precisa estar ligado no PC.

---

## ANTES DE COMEÇAR

Você precisa ter:

- Um PC com Windows.
- **MySQL** instalado e ligado (ou o **XAMPP**, com o MySQL ligado).
- Celular Android (se quiser testar no celular).
- PC e celular na **mesma rede Wi-Fi**.

> Se não tiver MySQL: instale o **XAMPP** em https://www.apachefriends.org, abra o painel e clique em **Start** no MySQL.

---

## PASSO 1 — INSTALAR O BANCO (só uma vez)

1. Abra a pasta do projeto (`TCC`).
2. Clique **duas vezes** em `instalar-banco.bat`.
3. Se o Windows perguntar, clique em **Sim**.
4. Digite a senha do MySQL.
   - Se você nunca colocou senha, só aperte **Enter**.
5. Espere aparecer:

```
BANCO PRONTO!
```

6. Aperte uma tecla para fechar.

**Pronto.** O banco foi criado e já tem 6 plantas de exemplo.

---

## PASSO 2 — LIGAR O SERVIDOR (toda vez que for usar)

1. Clique **duas vezes** em `start-server.bat`.
2. Vai abrir uma **janela preta**. **NÃO FECHE ESSA JANELA.**
3. Abra o navegador do PC e digite:

```
http://localhost:8080/app/
```

4. Se aparecer o catálogo com as plantas, **deu certo**.

> Para desligar o servidor, feche a janela preta.
> Para usar de novo, abra `start-server.bat` outra vez.

---

## PASSO 3 — TESTAR NO PC

Com o servidor ligado e o navegador aberto:

- Clique em uma planta para ver os detalhes.
- Use a busca no topo.
- Clique em **Solicitar planta** para fazer um pedido (visitantes).

> Se você já entrou como administrador, o botão **Solicitar** não aparece:
> no lugar dele fica **Cadastrar**, para cadastrar a planta direto no catálogo.

Se isso funcionou, o mais difícil já passou.

---

## PASSO 4 — INSTALAR NO CELULAR

1. Copie o arquivo abaixo para o celular (cabo USB, Google Drive ou WhatsApp):

```
dist\Sementes Digitais-1.0.0.apk
```

2. No celular, toque no arquivo e instale.
3. Se pedir permissão, autorize **instalar apps de fontes desconhecidas**.
4. Conecte o celular na **mesma Wi-Fi** do PC.
5. No PC, descubra o IP:
   - Aperte `Windows + R`
   - Digite `cmd` e aperte Enter
   - Digite `ipconfig` e aperte Enter
   - Procure **Endereço IPv4** (exemplo: `192.168.15.9`)
6. Abra o app **Sementes Digitais**.
7. Toque em **Perfil** → **Servidor da API**.
8. Digite o endereço com o IP que você viu:

```
http://SEU-IP:8080/api
```

Exemplo:

```
http://192.168.15.9:8080/api
```

9. Toque em **Testar conexão**.
10. Se aparecer que funcionou, toque em **Salvar**.
11. Volte para o catálogo.

> O IP pode mudar quando o PC reinicia ou troca de Wi-Fi. Se o app parar de carregar, confira o IP de novo.

---

## PASSO 5 — ENTRAR COMO ADMINISTRADOR

1. No app, vá em **Perfil**.
2. Toque em **Entrar como administrador**.
3. Use:

```
E-mail: admin@etec.sp.gov.br
Senha:  123456
```

4. Depois de entrar, abra **Painel** → **Solicitações**.

---

## COMO USAR O APP

### Ver uma planta
Toque no cartão da planta.

### Pedir uma planta nova (visitante)
Toque em **Solicitar planta**, preencha os dados, escolha uma foto e envie.
Essa opção é só para quem **não** está logado como administrador.

### Cadastrar uma planta direto (administrador)
1. Entre como administrador.
2. No menu de baixo, toque em **Cadastrar** (ou use **Cadastrar nova planta** no fim do catálogo).
3. Preencha os dados e escolha uma foto.
4. Toque em **Salvar planta**.

A planta entra no catálogo na hora, sem passar por aprovação.

### Aprovar um pedido
1. Entre como administrador.
2. Abra **Painel** → **Solicitações**.
3. Toque no pedido.
4. Toque em **Aprovar**.

A planta entra no catálogo automaticamente.

### Recusar um pedido
Mesmo caminho, mas toque em **Recusar** e escreva o motivo.

### Trocar a foto de uma planta já cadastrada
1. Entre como administrador.
2. Abra a planta no catálogo.
3. Toque em **Trocar foto da planta**.
4. Escolha uma imagem da galeria ou do celular.

A foto nova aparece na hora. Você precisa estar logado como administrador para ver esse botão.

### Excluir uma planta
1. Entre como administrador.
2. Abra a planta no catálogo.
3. Toque em **Excluir planta**.
4. Confirme em **Sim, excluir planta**.

A planta sai do catálogo. O histórico de pedidos já aprovados continua guardado.

### Enviar foto (galeria ou celular)
Quando o app pede uma foto, toque em **Escolher da galeria**.
Você pode escolher uma imagem que já está no celular. A câmera não abre sozinha.

### Sair da conta
**Perfil** → **Sair**.

---

## DEU ERRO? VEJA AQUI

| O que aparece | O que fazer |
|---|---|
| “Não foi possível conectar ao banco” | O MySQL está desligado ou a senha está errada. Ligue o MySQL e rode `instalar-banco.bat` de novo. |
| “Porta 8080 em uso” | Feche outras janelas pretas ou outros servidores e tente de novo. |
| O app não carrega as plantas | O `start-server.bat` está aberto? O celular está na mesma Wi-Fi? O IP está certo? |
| As fotos aparecem como “404” ou quebradas | Use o endereço da API com a pasta `api`, por exemplo `http://192.168.15.9:8080/api`. O app busca as fotos pelo mesmo servidor da API e, se uma foto não existir, mostra a imagem padrão. |
| “Não foi possível falar com o servidor” | Confira o endereço em **Perfil → Servidor da API**. |
| “A imagem deve ter no máximo 5 MB” | Escolha uma foto menor. |
| Tela branca no celular | Feche o app e abra de novo. |
| O Windows bloqueou a conexão | Permita o PHP na rede privada quando o Windows perguntar. |

---

## SE O `instalar-banco.bat` NÃO ACHAR O MYSQL

1. Instale o MySQL ou o XAMPP no local padrão.
2. Se usa XAMPP, confira se existe:

```
C:\xampp\mysql\bin\mysql.exe
```

3. Se usa MySQL, confira se existe algo parecido com:

```
C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe
```

4. Rode `instalar-banco.bat` de novo.

---

## O QUE TEM NO APP

- Catálogo de plantas com foto, descrição e cuidados.
- Busca por nome popular ou científico.
- Formulário para solicitar uma nova planta (visitantes).
- Envio de foto pelo celular.
- Login do administrador.
- Painel com os pedidos pendentes.
- Aprovar pedido (entra no catálogo).
- Recusar pedido com motivo.
- Cadastro direto de planta pelo administrador, sem pedido de aprovação.
- Trocar a foto de uma planta já cadastrada.
- Excluir planta do catálogo.
- Guarda o último catálogo no celular para continuar vendo sem internet.

---

## RESUMO RÁPIDO

Se você só quer decorar o essencial:

1. `instalar-banco.bat` → uma vez.
2. `start-server.bat` → deixar aberto.
3. Navegador: `http://localhost:8080/app/`
4. Celular: instalar o APK e configurar `http://SEU-IP:8080/api`.
5. Login: `admin@etec.sp.gov.br` / `123456`.

É só isso.
