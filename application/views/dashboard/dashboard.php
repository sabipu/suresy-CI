<main id="main">
  <div class="top-content">
    <div class="container">
      <div class="box dash__box">
        <div class="box__wrapper">
          <div class="steps__inner">
            <div class="columns">
              <div class="column">
                <div class="options">
                  <a href="https://www.suresy.com.au/make-a-claim/">
                    <span class="img-wrap">
                      <img src="../../../assets/images/ico-claim.png" alt="Suresy">
                    </span>
                    <span class="text">
                      Make a claim
                    </span>
                  </a>
                </div>
              </div>
              <div class="column">
                <div class="options">
                  <a href="/policy">
                    <span class="img-wrap">
                      <img src="../../../assets/images/ico-policy.png" alt="Suresy">
                    </span>
                    <span class="text">
                      View policy
                    </span>
                  </a>
                </div>
              </div>
              <div class="column">
                <div class="options">
                  <a href="/claims">
                    <span class="img-wrap">
                      <img src="../../../assets/images/ico-claim.png" alt="Suresy">
                    </span>
                    <span class="text">
                      View claims
                    </span>
                  </a>
                </div>
              </div>
              <!-- <div class="column">
                <div class="options">
                  <a href="/profile">
                    <span class="img-wrap">
                      <img src="../../../assets/images/ico-account.png" alt="Suresy">
                    </span>
                    <span class="text">
                      Manage account
                    </span>
                  </a>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="box__wrapper">
          <div class="steps__inner">
            <div class="dash__title">
              <span class="dash__title-text">Billing</span>
            </div>
            <div class="dash__text">
              <span class="subscription"><strong>$<?= isset($policy->quoted_monthly_premium) ? $policy->quoted_monthly_premium : 0 ?></strong> / month</span>
              <!-- <span class="due">Your next payment is due <strong>July 3, 2018</strong></span> -->
            </div>
          </div>
        </div>
<!--
        <div class="box__wrapper">
          <div class="steps__inner">
            <div class="dash__title">
              <span class="dash__title-text">Your claims</span>
            </div>
            <div class="dash__text">
              <?php if(!count($claims)) : ?>
                <span class="subscription small">You haven’t claimed anything yet.</span>
                <?php else : ?>
                <ul class="my-claim-list">
                  <?php foreach($claims as $i=>$claim) : ?>
                    <li>
                      <span class="subscription small">
                        <?= $claim->getTypeTitle() ?>
                        <strong>#<?= $claim->claim_id ?></strong>
                      </span>
                      <div class="wrap-info">
                        <div class="hold">DATE SUBMITTED: <span><?= $claim->created_date ?></span></div>
                        <div class="hold">Status: <span><?= $claim->claim_status ?></span></div>
                        <div class="hold">Claim Total: <span><?= $claim->claim_total ?></span></div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
-->
      </div>
    </div>
  </div>
</main>