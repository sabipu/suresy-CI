<section class="hero login-hero is-fullheight">
  <header class="hero-head">
    <div class="container">
      <div class="login-logo">
        <a href="/">
          <img src="../../../assets/images/logo.png" alt="Suresy">
        </a>
      </div>
      <div class="columns">
        <div class="column is-half is-offset-one-quarter">
          <div class="loginForm__wrapper">
            <h2 class="is-size-3 has-text-centered has-text-weight-bold">Set up your new <mark>password</mark></h2>
            <form action="/forgot/<?= $recovery_hash ?>" method="post">
              <?php if(isset($invalid) && $invalid == true) : ?>
              <div class="alert error">
                <?= $error_message ?>
              </div>
              <?php endif; ?>
              <div class="field">
                <label class="label" for="password">New password</label>
                <div class="control">
                  <input class="input" name="password" id="password" type="password" placeholder="Your password">
                </div>
              </div>
              <div class="field">
                <label class="label" for="re-password">Re-enter new password</label>
                <div class="control">
                  <input class="input" name="password" id="re-password" type="password" placeholder="Re-enter password">
                </div>
              </div>
              <div class="field">
                <div id="message"></div>
              </div>
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" type="submit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>
  <footer class="hero-foot">
    <strong class="copyright">&copy; <?= date('Y') ?> Suresy, a trading name of RAC Insurance Pty Limited AFSL 231222 (832 Wellington Street, West Perth, WA 6005)</strong>
    <span class="design">Website designed and developed with <i class="fas fa-heart"></i> by <a href="https://www.dilate.com.au/" target="_blank">Dilate</a></span>
  </footer>
</section>
