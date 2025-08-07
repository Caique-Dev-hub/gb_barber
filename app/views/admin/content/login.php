<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Elegante</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      width: 480px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-5px);
    }

    .login-card h2 {
      color: #333;
      font-size: 28px;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .input-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: #555;
      font-weight: 500;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s;
      outline: none;
    }

    .input-group input:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }

    .login-btn {
      width: 100%;
      padding: 14px;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
    }

    .login-btn:hover {
      background: linear-gradient(to right, #5a6fd1, #6a3d9a);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .forgot-password {
      display: block;
      margin-top: 15px;
      color: #667eea;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s;
    }

    .forgot-password:hover {
      color: #764ba2;
    }

    .divider {
      margin: 25px 0;
      height: 1px;
      background: linear-gradient(to right, transparent, #e0e0e0, transparent);
    }

    .social-login {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f5f5f5;
      color: #555;
      text-decoration: none;
      transition: all 0.3s;
    }

    .social-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div class="login-card">
    <h2>Administrador</h2>
    <form action="<?= URL_BASE?>dash" method="POST">
      <div class="input-group">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
      </div>
      <div class="input-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
      </div>
      <button type="submit" class="login-btn">Entrar</button>
    </form>
  </div>
</body>

</html>