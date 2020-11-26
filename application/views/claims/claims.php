<main id="main">
  <div class="top-content">
    <div class="container">
      <div class="box dash__box">
        <div class="box__wrapper">
          <div class="steps__inner">
            <div class="dash__title">
              <span class="dash__title-text">Your claims</span>
            </div>
            <div class="dash__text">
              <?php if(!count($claims)) : ?>
                <span class="subscription small">You haven’t claimed anything yet.</span>
                <span class="due">Claims are updated every <strong>24hr</strong> after one of our representative reviews it.</span>
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
                <span class="due top__space">Claims are updated every <strong>24hr</strong> after one of our representative reviews it.</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>