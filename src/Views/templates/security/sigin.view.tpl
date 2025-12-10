<section class="fullCenter" style="background-color:#001f3f; color:white; min-height:100vh; display:flex; justify-content:center; align-items:center;">
  <form class="grid" method="post" action="index.php?page=sec_register" style="background-color:#003366; padding:30px; border-radius:8px; width:100%; max-width:500px;">
    <section class="depth-1 row col-12">
      <h1 class="col-12 text-center" style="margin-bottom:20px;">Crea tu cuenta</h1>
    </section>
    <section class="depth-1 py-3 row col-12">
      <div class="row mb-3">
        <label class="col-12 col-m-4 flex align-center" for="txtEmail">Correo Electrónico</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="email" id="txtEmail" name="txtEmail" value="{{txtEmail}}" style="width:100%; padding:8px; border-radius:5px; border:none;"/>
        </div>
        {{if errorEmail}}
        <div class="error col-12 py-2 col-m-8 offset-m-4" style="color:#ff6b6b;">{{errorEmail}}</div>
        {{endif errorEmail}}
      </div>
      <div class="row mb-3">
        <label class="col-12 col-m-4 flex align-center" for="txtPswd">Contraseña</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="password" id="txtPswd" name="txtPswd" value="{{txtPswd}}" style="width:100%; padding:8px; border-radius:5px; border:none;"/>
        </div>
        {{if errorPswd}}
        <div class="error col-12 py-2 col-m-8 offset-m-4" style="color:#ff6b6b;">{{errorPswd}}</div>
        {{endif errorPswd}}
      </div>
      <div class="row right flex-end px-4 mt-3">
        <button class="primary" id="btnSignin" type="submit" style="background-color:#5dade2; color:white; padding:10px 20px; border:none; border-radius:5px;">Crear Cuenta</button>
      </div>
    </section>
  </form>
</section>
