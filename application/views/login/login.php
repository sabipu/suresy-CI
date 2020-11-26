<header class="hero-head">
  <div class="container">
    <div class="login-logo">
      <a href="https://suresy.dilatedigital.com.au/">
        <img src="../../../assets/images/logo.png" alt="Suresy">
      </a>
    </div>
    <div class="columns">
      <div class="column is-12">
        <div class="loginForm__wrapper">
          <div class="spinner-loader">
            <div class="lds-roller">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
            </div>
          </div>
          <div class="login__holder">
            <form action="/login" method="post" class="login__form">
              <h2 class="is-size-3 has-text-centered has-text-weight-bold main-head"><mark>Login</mark></h2>
              <?php if(isset($invalid) && $invalid == true) : ?>
              <div class="alert error">
                <?= $error_message ?>
              </div>
              <?php endif; ?>
              <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                  <input class="input" name="email" id="email" type="email" placeholder="Your email" required>
                </div>
              </div>
              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                  <input class="input" name="password" id="password" type="password" placeholder="Your password">
                </div>
              </div>
              <input type="hidden" name="r" value="<?= $ref ?>" />
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" type="submit">Submit</button>
                </div>
                <div class="control">
                  <a href="/login" class="button is-text forgot__button">Forgot password</a>
                </div>
              </div>
            </form>
          </div>
          <div class="recover__holder">
            <form action="/forgot" method="post" class="forgot__form">
              <h2 class="is-size-3 has-text-centered has-text-weight-bold">Recover <mark>password</mark></h2>
              <div class="field">
                <label class="label" for="recover_email">Email address</label>
                <div class="control">
                  <input class="input" name="recover_email" id="recover_email" type="email" placeholder="Your email">
                </div>
              </div>
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" type="submit">Submit</button>
                </div>
                <div class="control">
                  <a href="/login" class="button is-text forgot__button" type="submit">Back to Login</a>
                </div>
              </div>
            </form>
          </div>
          <div class="message__holder">
            <h2 class="is-size-3 message-heading has-text-weight-bold has-text-centered">&nbsp;</h2>
            <p class="message-text">&nbsp;</p>
            <div class="field is-grouped">
              <div class="control">
                <a href="/login" class="button is-link btn-login">Back to Login</a>
                <a href="/login" class="button is-link btn-try">Try again</a>
              </div>
              <div class="control">
                <a href="https://www.suresy.com.au/need-help/" class="button is-text" type="submit">Contact Support</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>