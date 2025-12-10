<section class="fullCenter" 
         style="background-color:#001f3f; min-height:100vh; padding-top:40px; color:white;">

  <form class="grid" 
        method="post" 
        action="index.php?page=sec_login{{if redirto}}&redirto={{redirto}}{{endif redirto}}"
        style="width:100%; max-width:500px; margin:auto;">

    <!-- Título -->
    <section class="depth-1 row col-12"
             style="background-color:#003366; padding:20px; border-radius:10px; text-align:center; margin-bottom:20px;">
      <h1 style="margin:0; color:white;">Iniciar Sesión</h1>
    </section>

    <!-- Form Container -->
    <section class="depth-1 py-5 row col-12"
             style="background-color:#003366; padding:30px; border-radius:10px;">

      <!-- Email -->
      <div class="row" style="margin-bottom:18px;">
        <label class="col-12" for="txtEmail" 
               style="margin-bottom:6px; font-weight:bold;">
            Correo Electrónico
        </label>
        <div class="col-12">
          <input class="width-full" 
                 type="email" 
                 id="txtEmail" 
                 name="txtEmail" 
                 value="{{txtEmail}}"
                 style="padding:10px; width:100%; border-radius:6px; border:none;"/>
        </div>

        {{if errorEmail}}
          <div class="error col-12 py-2" 
               style="color:#ff6b6b;">
            {{errorEmail}}
          </div>
        {{endif errorEmail}}
      </div>

      <!-- Password -->
      <div class="row" style="margin-bottom:18px;">
        <label class="col-12" for="txtPswd" 
               style="margin-bottom:6px; font-weight:bold;">
            Contraseña
        </label>
        <div class="col-12">
          <input class="width-full" 
                 type="password" 
                 id="txtPswd" 
                 name="txtPswd" 
                 value="{{txtPswd}}"
                 style="padding:10px; width:100%; border-radius:6px; border:none;"/>
        </div>

        {{if errorPswd}}
          <div class="error col-12 py-2" 
               style="color:#ff6b6b;">
            {{errorPswd}}
          </div>
        {{endif errorPswd}}
      </div>

      <!-- Errores generales -->
      {{if generalError}}
      <div class="row" style="color:#ff6b6b; margin-bottom:10px;">
        {{generalError}}
      </div>
      {{endif generalError}}

      <!-- Botón de Login -->
      <div class="row" style="text-align:right; margin-top:10px;">
        <button class="primary" 
                id="btnLogin" 
                type="submit"
                style="
                  background-color:#5dade2;
                  color:white;
                  padding:10px 20px;
                  border:none;
                  border-radius:6px;
                  font-size:1rem;
                  font-weight:bold;
                  cursor:pointer;
                ">
          Iniciar Sesión
        </button>
      </div>

    </section>

  </form>
</section>
