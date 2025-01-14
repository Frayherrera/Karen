<x-guest-layout>
    <div class="container">
        <div class="heading">Iniciar Sesión</div>
        <form class="form" method="POST" action="{{ route('login') }}">
            @csrf
            <input required="" class="input" type="email" name="email" id="email" placeholder="E-mail">
            <input required="" class="input" type="password" name="password" id="password" placeholder="Password">
            <input class="login-button" type="submit" value="Iniciar">
        </form>
    </div>
</x-guest-layout>

<style>
    .container {
        max-width: 350px;
        background: #FDF2F8;
        background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(251, 244, 247) 100%);
        border-radius: 40px;
        padding: 25px 35px;
        border: 5px solid rgb(255, 255, 255);
        box-shadow: rgba(215, 133, 189, 0.878) 0px 30px 30px -20px;
        margin: 20px;
    }

    .heading {
        text-align: center;
        font-weight: 900;
        font-size: 30px;
        color: rgb(219, 39, 119);
    }

    .form {
        margin-top: 20px;
    }

    .form .input {
        width: 100%;
        background: white;
        border: none;
        padding: 15px 20px;
        border-radius: 20px;
        margin-top: 15px;
        box-shadow: #ffd1e8 0px 10px 10px -5px;
        border-inline: 2px solid transparent;
    }

    .form .input::-moz-placeholder {
        color: rgb(170, 170, 170);
    }

    .form .input::placeholder {
        color: rgb(170, 170, 170);
    }

    .form .input:focus {
        outline: none;
        border-inline: 2px solid #EC4899;
    }

    .form .forgot-password {
        display: block;
        margin-top: 10px;
        margin-left: 10px;
    }

    .form .forgot-password a {
        font-size: 11px;
        color: #DB2777;
        text-decoration: none;
    }
    
    .login-button:hover {
        cursor: pointer;
    }

    .form .login-button {
        display: block;
        width: 100%;
        font-weight: bold;
        background: linear-gradient(45deg, rgb(219, 39, 119) 0%, rgb(236, 72, 153) 100%);
        color: white;
        padding-block: 15px;
        margin: 20px auto;
        border-radius: 20px;
        box-shadow: rgba(215, 133, 189, 0.878) 0px 20px 10px -15px;
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .form .login-button:hover {
        transform: scale(1.03);
        box-shadow: rgba(215, 133, 189, 0.878) 0px 23px 10px -20px;
    }

    .form .login-button:active {
        transform: scale(0.95);
        box-shadow: rgba(215, 133, 189, 0.878) 0px 15px 10px -10px;
    }

    .social-account-container {
        margin-top: 25px;
    }

    .social-account-container .title {
        display: block;
        text-align: center;
        font-size: 10px;
        color: rgb(170, 170, 170);
    }

    .social-account-container .social-accounts {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 5px;
    }

    .social-account-container .social-accounts .social-button {
        background: linear-gradient(45deg, rgb(219, 39, 119) 0%, rgb(236, 72, 153) 100%);
        border: 5px solid white;
        padding: 5px;
        border-radius: 50%;
        width: 40px;
        aspect-ratio: 1;
        display: grid;
        place-content: center;
        box-shadow: rgba(215, 133, 189, 0.878) 0px 12px 10px -8px;
        transition: all 0.2s ease-in-out;
    }

    .social-account-container .social-accounts .social-button .svg {
        fill: white;
        margin: auto;
    }

    .social-account-container .social-accounts .social-button:hover {
        transform: scale(1.2);
    }

    .social-account-container .social-accounts .social-button:active {
        transform: scale(0.9);
    }

    .agreement {
        display: block;
        text-align: center;
        margin-top: 15px;
    }

    .agreement a {
        text-decoration: none;
        color: #DB2777;
        font-size: 9px;
    }
</style>