<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Variation System Login</title>
  <script src="https://kit.fontawesome.com/66aa7c98b3.js" crossorigin="anonymous"></script>
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.container {
  height: 100vh;
  margin: 0 auto;
  position: relative;
  /* background: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed); */
}

.container .form-1 {
  display: flex;
  flex-direction: column;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  width: 40%;
  box-shadow: 0 19px 38px rgba(0, 0, 0, 0.3);
}

.form-1 h1 {
  text-align: center;
  margin-top: 0.7rem;
  margin-bottom: 1.5rem;
}

input[type="email"],
input[type="password"] {
  border: none;
  outline: none;
  border-bottom: 1px solid;
  background: none;
  margin: 0.9rem 2rem;
  font-size: 1rem;
  padding:5px;
}

label {
  margin: 0 2rem;
}

span {
  margin: 0 2rem;
  color: red;
  cursor: pointer;
}

button {
  margin: 2rem;
  margin-bottom: 1.5rem;
  padding: 13px;
  cursor: pointer;
  border-radius: 1rem;
  border: none;
  font-size: 1.1rem;
  font-weight: bolder;
  color: #fff;
  background: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed);
}


/* ....///Media query///..... */

@media (max-width: 501px) {
  html {
    font-size: 15px;
  }

  .container .form-1 {
    width: 300px;
  }
}

@media (min-width: 501px) and (max-width: 768px) {
  html {
    font-size: 14px;
  }

  .container .form-1 {
    width: 450px;
  }
}

@media (min-width: 765px) and (max-width: 1200px) {
  html {
    font-size: 18px;
  }

  .container .form-1 {
    width: 540px;
    height: 550px;
  }
}

@media (orientation: landscape) and (max-height: 500px) {
  .container {
    height: 100vmax;
  }
}
  </style>
</head>

<body>
  <div class="container">
    <form class="form-1" method="POST" action="{{ route('login') }}">
        @csrf
      <h1>Admin Log In</h1>
      <label for="email">Email Address</label>
      <input type="email" name="email" id="email" required />
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required />
       @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      <button type="submit">Login</button>
    </form>
  </div>
</body>

</html>