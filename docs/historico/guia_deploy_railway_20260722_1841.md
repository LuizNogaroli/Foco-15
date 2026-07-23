# Guia de Deploy Laravel no Railway

Este é o seu mapa passo a passo para replicar a mágica do `Push -> Deploy` (estilo Vercel) usando a infraestrutura do **Railway** para o nosso sistema Laravel.

## 1. Preparação no Github
Antes de ir para o Railway, certifique-se de que todo o seu código mais recente está no GitHub.
```bash
git add .
git commit -m "Preparando para deploy no Railway"
git push origin main
```

## 2. Criando o Projeto no Railway
1. Acesse [railway.app](https://railway.app/) e faça login com a sua conta do GitHub.
2. No painel principal, clique no botão **"New Project"**.
3. Selecione a opção **"Deploy from GitHub repo"**.
4. Busque e selecione o repositório do `Foco-15` (ou o nome que você deu ao repositório no GitHub).
5. O Railway vai detectar automaticamente que é um projeto PHP/Laravel e começará a fazer o build inicial. **Atenção: esse primeiro build provavelmente vai falhar ou a tela vai ficar em branco.** Isso é normal! O sistema ainda não tem as senhas do seu banco de dados e a chave de segurança.

## 3. Configurando as Variáveis de Ambiente (O Segredo!)
Assim como você tem um arquivo `.env` no seu computador local, o servidor do Railway precisa das mesmas variáveis para funcionar.

1. Clique no seu projeto recém-criado no Railway e vá na aba **"Variables"**.
2. Clique no botão **"Raw Editor"** (ou crie uma por uma).
3. Cole as seguintes variáveis obrigatórias (ajustando com os seus dados reais):

```env
APP_NAME=SPUnet
APP_ENV=production
APP_KEY=base64:COLE_AQUI_A_SUA_CHAVE_LOCAL
APP_DEBUG=false
APP_URL=https://NOME-DO-SEU-APP.up.railway.app

# Configurações do Banco de Dados (Supabase)
DB_CONNECTION=pgsql
DB_HOST=aws-0-sa-east-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.seu_id
DB_PASSWORD=sua_senha_do_supabase

# Força o Railway a usar HTTPS
ASSET_URL=https://NOME-DO-SEU-APP.up.railway.app
```
> Atenção: A `APP_KEY` deve ser exatamente a mesma que está no seu arquivo `.env` local no seu computador (aquela que começa com `base64:...`).

## 4. Ajustando o Build Command (Opcional, mas Recomendado)
O Railway compila o PHP automaticamente, mas às vezes precisamos garantir que ele gere os nossos arquivos de CSS/JS (o Vite).

1. Vá na aba **"Settings"** do seu serviço no Railway.
2. Role até a seção **"Build"**.
3. Em **Build Command**, coloque o seguinte comando personalizado:
```bash
composer install --no-dev --optimize-autoloader && npm install && npm run build
```
Isso garante que toda vez que você fizer push, ele vai otimizar o código do Laravel e compilar as últimas versões do seu layout de tela cheia.

## 5. Gerando o Link Público e Finalizando
1. Ainda na aba **"Settings"**, role até a seção **"Environment"** -> **"Domains"**.
2. Clique no botão **"Generate Domain"**. O Railway vai criar um link público gratuito (ex: `foco15-production.up.railway.app`) para você mandar pro cliente!
3. Após preencher as variáveis e o domínio, o Railway fará um novo deploy automático. Se não fizer, clique no botão superior direito "Deploy".

## Como Fica o Fluxo de Trabalho a Partir de Agora?
Igualzinho à Vercel!
Sempre que nós dois desenvolvermos uma tela nova aqui, você só precisa rodar:
```bash
git push
```
E em cerca de 2 minutos, a tela estará atualizada e no ar no link do cliente!
