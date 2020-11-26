<main id="main">
    <div class="top-content">
      <div class="container">
        <div class="box">
          <div class="policy__wrap">
            <div class="policy__header">
              <div class="columns">
                <div class="column is-one-third">
                  <span class="policy__number"><mark>Policy #</mark> <span class="num"><?= isset($policy->policy_data_id) ? $policy->policy_data_id : '' ?></span></span>
                  <div class="btn__wrap">
                    <a href="/policy/update/<?= isset($policy->policy_data_id) ? $policy->policy_data_id : '' ?>" class="button is-link">Change Policy</a>
                  </div>
                  <div class="btn__wrap">
                    <!-- <a href="#" class="button is-dark">Download PDF</a> -->
                  </div>
                  <div class="btn__wrap">
                    <a href="https://www.suresy.com.au/pds/" class="button is-dark">Product Disclosure Statement</a>
                  </div>
                  <div class="btn__wrap">
                    <a href="https://www.suresy.com.au/key-facts-sheet/" class="button is-dark">Key Facts Sheet</a>
                  </div>
                  
                  <div class="contact__wrap">
                    <span class="policy__head"><mark>Support</mark></span>
                    <span class="policy__text"><a href="mailto:help@suresy.com.au">help@suresy.com.au</a></span>
                  </div>
                </div>
                <div class="column is-two-third">
                  <div class="policy__info__wrap">
                    <div class="policy__info__holder">
                      <span class="policy__head">Policyholder</span>
                      <span class="policy__text"><?= isset($policy->first_name) ? ucfirst($policy->first_name) : '' ?> <?= isset($policy->last_name) ? ucfirst($policy->last_name) : '' ?></span>
                    </div>
                    <div class="policy__info__holder">
                      <span class="policy__head"><mark>Policy start date</mark></span>
                      <span class="policy__text">
                        <?php
                          if(isset($policy->policy_start_date)) {
                            echo date("d F Y",strtotime($policy->policy_start_date));
                          }
                        ?>
                      </span>
                    </div>
                    <div class="policy__info__holder">
                      <span class="policy__head"><mark>Address</mark></span>
                      <span class="policy__text"><?= isset($policy->address) ? $policy->address : '' ?></span>
                    </div>
                    <div class="policy__info__holder">
                      <span class="policy__head"><mark>Policy expires on</mark></span>
                      <span class="policy__text">
                        <?php
                          if(isset($policy->policy_start_date)) {
                            echo date("d F Y",strtotime($policy->getExpiryDate()));
                          }
                        ?>
                      </span>
                    </div>
                    <div class="policy__info__holder">
                      <span class="policy__head"><mark>Alarm</mark></span>
                      <span class="policy__text">
                        <?php 
                          if(isset($policy->burglar_alarm) && $policy->burglar_alarm === 'true') {
                            echo 'Yes';
                          }else {
                            echo 'No';
                          }
                        ?>
                      </span>
                    </div>
                    <div class="policy__info__holder">
                      <span class="policy__head"><mark>Dog</mark></span>
                      <span class="policy__text">
                        <?php 
                          if(isset($policy->dog) && $policy->dog === 'true') {
                            echo 'Yes';
                          }else {
                            echo 'No';
                          }
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="policy__calc">
              <header class="policy__heading">
                <h2><mark>Cover & premium calculator</mark></h2>
              </header>
              <div class="table-holder">
                <table class="policy__table responsive__table">
                  <colgroup>
                    <col>
                    <col>
                    <col>
                  </colgroup>
                  <thead>
                    <tr>
                      <th>Cover</th>
                      <th>Max amount</th>
                      <th>Cost</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="v__top">
                      <td data-label="Cover Type">
                        <span class="main__info">
                          <?php 
                            if(isset($policy->cover_type) && $policy->cover_type === 'ADFT') {
                              echo 'Accidental Loss or damage to contents and loss of or damage to contents caused by fire and/or theft';
                            }elseif(isset($policy->cover_type) && $policy->cover_type === 'FT') {
                              echo 'Loss of or damage to contents caused by fire and/or theft';
                            }elseif(isset($policy->cover_type) && $policy->cover_type === 'TO') {
                              echo 'Loss of or damage to contents caused by theft only';
                            }else {
                              echo 'Coverage Type';
                            }
                          ?>
                        </span>
                      </td>
                      <td data-label="Max amount" class="responsive__hidden">
                        <span class="price">See below</span>
                      </td>
                      <td data-label="Cost" class="responsive__hidden">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Household items <span class="max">(maximum $5,000 per item)</span></span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->cover_household) ? number_format($policy->cover_household) : 0 ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Portable electronics <span class="max">(maximum $2,500 per item)</span></span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->cover_electronics) ? number_format($policy->cover_electronics) : 0 ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Jewellery <span class="max">(maximum $2,500 per item)</span></span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->cover_jewellery) ? number_format($policy->cover_jewellery) : 0 ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Sports equipment <span class="max">(maximum $2,500 per item)</span></span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->cover_sports) ? number_format($policy->cover_sports) : 0 ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Legal liability</span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->cover_type) ? '20,000,000' : '0' ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Cover">
                        <span class="row__title">Excess</span>
                      </td>
                      <td data-label="Max amount">
                        <span class="price">$<?= isset($policy->excess) ? number_format(intval($policy->excess)+500) : 0 ?></span>
                      </td>
                      <td data-label="Cost">
                        <span class="info">Included</span>
                      </td>
                    </tr>
                    <tr class="space">
                      <td colspan="3"></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr class="bottom">
                      <td data-label="Cover">Net premium</td>
                      <td data-label="Cover" colspan="2">$<?= isset($policy->annual_net_premium) ? number_format($policy->annual_net_premium, 2) : 0 ?></td>
                    </tr>
                    <tr class="bottom">
                      <td data-label="Cover">GST</td>
                      <td data-label="Cover" colspan="2">$<?= isset($policy->annual_gst) ? number_format($policy->monthly_gst * 12, 2) : 0 ?></td>
                    </tr>
                    <tr class="bottom">
                      <td data-label="Cover">Stamp duty</td>
                      <td data-label="Cover" colspan="2">$<?= isset($policy->annual_stamp_duty) ? number_format($policy->monthly_stamp_duty * 12, 2) : 0 ?></td>
                    </tr>
                    <tr>
                      <td data-label="Cover">Total premium</td>
                      <td data-label="Cover" colspan="2">
                        <span class="total">$<?= isset($policy->quoted_annual_premium) ? number_format($policy->quoted_annual_premium, 2) : 0 ?></span>
                        <span class="month">$<?= isset($policy->quoted_monthly_premium) ? number_format($policy->quoted_monthly_premium, 2) : 0 ?>/month</span>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <span class="bill__info">This will be a tax invoice for GST purposes upon payment.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>