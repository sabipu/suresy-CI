<main id="main">
  <div class="top-content">
    <div class="container">
      <div class="box">
        <div class="steps__inner">
          <div class="general__heading">
            <h3 class="is-size-4"><mark>Edit your details.</mark></h3>
            <h4 class="has-text-weight-bold is-size-3 claim__heading">Edit your <mark>details</mark> below providing important informations.</h4>
            <div id="update_policy_error_message"></div>
          </div>
        </div>
        <form class="policy__update" action="#" method="POST">
          <div id="step1" class="policy__step step__active">
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Personal information</h3>
                  <div class="columns no__bottom">
                    <div class="column">
                      <div class="field">
                        <input type="text" class="input" placeholder="First name" name="f-name" id="first-name" value="<?= $user->first_name ?>">
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <input type="text" class="input" placeholder="First name" name="l-name" id="last-name" value="<?= $user->last_name ?>">
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <input type="email" class="input" placeholder="Email address" name="email" id="email" value="<?= $user->email ?>">
                    <div id="address_error"></div>
                  </div>
                  <div class="field">
                    <input id="address" class="input" name="address" placeholder="Enter your address" type="text" value="<?= $user->address ?>" />
                  </div>
                  <div class="field">
                    <div class="map__holder" id="map">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Do you have any of the <mark>following</mark> in your home?</h3>
                  <ul class="claim__list">
                    <li>
                      <label class="claim__check">
                        <input type="checkbox" name="burglar_alarm" checked="checked">
                        <span class="claim__check-wrap">
                          <div class="img__wrap">
                            <img src="../../../assets/images/thief.svg" width="120" alt="Suresy" class="normal">
                            <img src="../../../assets/images/thief-blue.svg" width="120" alt="Suresy" class="check-active">
                            <span class="check__tick">&nbsp;</span>
                          </div>
                          <span class="title">Burglar Alarm</span>
                        </span>
                      </label>
                    </li>
                    <li>
                      <label class="claim__check">
                        <input type="checkbox" name="dog">
                        <span class="claim__check-wrap">
                          <div class="img__wrap">
                            <img src="../../../assets/images/dog.svg" width="120" alt="Suresy" class="normal">
                            <img src="../../../assets/images/dog-blue.svg" width="120" alt="Suresy" class="check-active">
                            <span class="check__tick">&nbsp;</span>
                          </div>
                          <span class="title">Dog</span>
                        </span>
                      </label>
                    </li>
                    <li>
                      <label class="claim__check">
                        <input type="checkbox" name="housemate">
                        <span class="claim__check-wrap">
                          <div class="img__wrap">
                            <img src="../../../assets/images/damage.svg" width="78" alt="Suresy" class="normal">
                            <img src="../../../assets/images/damage-blue.svg" width="78" alt="Suresy" class="check-active">
                            <span class="check__tick">&nbsp;</span>
                          </div>
                          <span class="title">Housemates</span>
                        </span>
                      </label>
                    </li>
                  </ul>
                  <span class="claim__info">Your housemates things aren't covered. They'll need to buy their own cover.</span>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Adjust your <mark>cover</mark></h3>
                  <div id="cover_error"></div>
                  <ul class="cover__list">
                    <li>
                      <div class="cover__wrap">
                        <span class="title">Household items</span>
                        <div class="img">
                          <img src="../../../assets/images/household.jpg" alt="Suresy">
                        </div>
                        <div class="amount__holder">
                          <input type="text" class="input" name="cover_house" id="cover_house" data-value="5000" data-max="100000" value="$0" disabled="disabled">
                        </div>
                        <div class="amount__control">
                          <button class="control minus">-</button>
                          <button class="control plus">+</button>
                        </div>
                        <p>This is the maximum amount we can pay for household items. Examples include furniture, clothing, TV's and home appliances.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <span class="title">Portable electronics</span>
                        <div class="img">
                          <img src="../../../assets/images/electronics.jpg" alt="Suresy">
                        </div>
                        <div class="amount__holder">
                          <input type="text" class="input" name="cover_electronics" id="cover_electronics" data-value="500"  data-max="10000" value="$0" disabled="disabled">
                        </div>
                        <div class="amount__control">
                          <button class="control minus">-</button>
                          <button class="control plus">+</button>
                        </div>
                        <p>This is the maximum amount we can pay for household items. Examples include furniture, clothing, TV's and home appliances.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <span class="title">Jewellery</span>
                        <div class="img">
                          <img src="../../../assets/images/jewellery.jpg" alt="Suresy">
                        </div>
                        <div class="amount__holder">
                          <input type="text" class="input" name="cover_jewellery" id="cover_jewellery" value="$0"  data-max="5000" data-value="1000" disabled="disabled">
                        </div>
                        <div class="amount__control">
                          <button class="control minus">-</button>
                          <button class="control plus">+</button>
                        </div>
                        <p>This is the maximum amount we can pay for household items. Examples include furniture, clothing, TV's and home appliances.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <span class="title">Sports equipment</span>
                        <div class="img">
                          <img src="../../../assets/images/sports.jpg" alt="Suresy">
                        </div>
                        <div class="amount__holder">
                          <input type="text" class="input" value="$0"  data-max="10000" data-value="1000" name="cover_sports" id="cover_sports" disabled="disabled">
                        </div>
                        <div class="amount__control">
                          <button class="control minus">-</button>
                          <button class="control plus">+</button>
                        </div>
                        <p>This is the maximum amount we can pay for household items. Examples include furniture, clothing, TV's and home appliances.</p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Choose your <mark>excess</mark></h3>
                  <p class="has-text-centered">This is the amount you need to pay towards any claim. The higher the excess the lower the premium - and vice versa.</p>
                  <div class="form__wrap">
                    <div class="hold">
                      <span class="form__title">Excess</span>
                    </div>
                    <div class="hold">
                      <div class="select">
                        <select name="excess" class="fc-select" id="excess">
                          <option value="-500" data-rate="1.54">-$500</option>
                          <option value="-400" data-rate="1.4">-$400</option>
                          <option value="-300" data-rate="1.28">-$300</option>
                          <option value="-200" data-rate="1.17">-$200</option>
                          <option value="-100" data-rate="1.075">-$100</option>
                          <option value="0" data-rate="1.00">$0</option>
                          <option value="100" data-rate="0.955">$100</option>
                          <option value="200" data-rate="0.926">$200</option>
                          <option value="300" data-rate="0.909">$300</option>
                          <option value="400" data-rate="0.870">$400</option>
                          <option value="500" data-rate="0.842" selected="">$500</option>
                          <option value="600" data-rate="0.835">$600</option>
                          <option value="700" data-rate="0.825">$700</option>
                          <option value="800" data-rate="0.820">$800</option>
                          <option value="900" data-rate="0.808">$900</option>
                          <option value="1000" data-rate="0.796">$1,000</option>
                          <option value="1100" data-rate="0.785">$1,100</option>
                          <option value="1200" data-rate="0.774">$1,200</option>
                          <option value="1300" data-rate="0.763">$1,300</option>
                          <option value="1400" data-rate="0.755">$1,400</option>
                          <option value="1500" data-rate="0.750">$1,500</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Include them on my <mark>policy</mark></h3>
                  <div class="include__policy">
                    <div class="columns">
                      <div class="column">
                        <div class="field">
                          <input type="text" class="input ignore-input" placeholder="Name" name="policy_name" id="policy_name">
                        </div>
                        <h4 class="has-text-weight-bold">Relationship with the person?</h4>
                        <div class="field">
                          <div class="select">
                            <select name="ignore-input policy_relation" id="policy_relation">
                              <option disabled="disabled" selected="selected">Pick One...</option>
                              <option>Son</option>
                              <option>Daughter</option>
                              <option>Mom</option>
                              <option>Dad</option>
                              <option>Spouse</option>
                              <option>Family Member</option>
                            </select>
                          </div>
                        </div>
                        <div class="field">
                          <button type="button" id="addto__policy" class="button is-link">Add to policy <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                        </div>
                      </div>
                      <div class="column">
                        <div class="info__right">
                          <h3 class="is-size-4"><mark>Policy Includes</mark></h3>
                          <div id="policy_includes"></div>
                          <script id="policy_includes_template" type="x-tmpl-mustache">
                            <div class="include__member" data-item='{{num}}'>
                              <a class="include__member--remove delete is-medium" href="#"><span></span></a>
                              <span class="include__member--relation">{{relation}}:</span>
                              <strong class="include__member--name">{{name}}</strong>
                            </div>
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="step2" class="policy__step">
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder no__number">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Update your package</h3>
                  <p class="has-text-centered">Some of the changes you have made affect the price of your policy. Here is the updated pricing and options your have. Please choose one to complete the changes to your policy.</p>
                  <ul class="package__list">
                    <li>
                      <div class="holder">
                        <div class="price__wrap">
                          <div class="price__circle">
                            <span class="price"><span class="dollar">$</span>2</span>
                            <span class="text">/month</span>
                          </div>
                          <ul class="icons-wrap">
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-theft.png" alt="Suresy">
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="text__wrap">
                          <h3>Theft Only</h3>
                          <a href="#" class="button is-dark">Choose</a>
                        </div>
                      </div>
                    </li>
                    <li class="best__option center__one">
                      <div class="holder">
                        <span class="best"><span>Best Cover!</span></span>
                        <div class="price__wrap">
                          <div class="price__circle">
                            <span class="price"><span class="dollar">$</span>6</span>
                            <span class="text">/month</span>
                          </div>
                          <ul class="icons-wrap">
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-laptop.png" alt="Suresy">
                              </div>
                            </li>
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-fire.png" alt="Suresy">
                              </div>
                            </li>
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-theft.png" alt="Suresy">
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="text__wrap">
                          <h3>Accidental Damage,<br> Fire & Theft</h3>
                          <a href="#" class="button is-dark">Choose</a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="holder">
                        <div class="price__wrap">
                          <div class="price__circle">
                            <span class="price"><span class="dollar">$</span>3</span>
                            <span class="text">/month</span>
                          </div>
                          <ul class="icons-wrap">
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-fire.png" alt="Suresy">
                              </div>
                            </li>
                            <li>
                              <div class="hold">
                                <img src="../../../assets/images/ico-theft.png" alt="Suresy">
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="text__wrap">
                          <h3>Fire &amp; Theft</h3>
                          <a href="#" class="button is-dark">Choose</a>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div id="step3" class="policy__step">
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Changes on your <mark>policy</mark></h3>
                  <p class="has-text-centered">Please review your changes below and if you need any changes go back and edit.</p>
                  <div class="changes">
                    <dl class="changes__holder">
                      <dt>First Name:</dt>
                      <dd>Bipu</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Last Name:</dt>
                      <dd>Bajgai</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Email:</dt>
                      <dd>bipu@dilate.com.au</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Address:</dt>
                      <dd>8 Ernest drive, success WA 6164, Australia</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Burglar Alarm:</dt>
                      <dd>Yes</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Household Items:</dt>
                      <dd>$20,000</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Excess:</dt>
                      <dd>$1,000</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Include:</dt>
                      <dd>Travis Weerts (Friend)</dd>
                    </dl>
                    <dl class="changes__holder">
                      <dt>Policy:</dt>
                      <dd>$6/month <br><mark>Accidental Damage, Fire and Theft</mark></dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Whats <mark>covered</mark>?</h3>
                  <ul class="cover__list whats__covered">
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/mobile.jpg" alt="Suresy">
                        </div>
                        <span class="title">Accidental damage</span>
                        <p>Does exactly what it says on the tin. You accidentally leave your tablet on the train one day. Covered. Your TV smashes due to a rowdy kids' game gone wrong. Covered. Your smartphone falls from your pocket into the toilet. Covered.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/fire.jpg" alt="Suresy">
                        </div>
                        <span class="title">Fire and smoke</span>
                        <p>Your attempt at deep frying calamari or a faulty power charger can cause smoke and fire damage. We cover you for both.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/rain.jpg" alt="Suresy">
                        </div>
                        <span class="title">Bad weather</span>
                        <p>High winds, a big storm, lightning and bushfires aren't fun. You're covered for all of them.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/theft.jpg" alt="Suresy">
                        </div>
                        <span class="title">Theft</span>
                        <p>We cover your things if they are stolen or damaged as a result of theft/attempted theft.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/australia.jpg" alt="Suresy">
                        </div>
                        <span class="title">Australia wide</span>
                        <p>We cover your things anywhere in Australia and whilst in storage.</p>
                      </div>
                    </li>
                    <li>
                      <div class="cover__wrap">
                        <div class="img">
                          <img src="../../../assets/images/dog.jpg" alt="Suresy">
                        </div>
                        <span class="title">Liability</span>
                        <p>Your pet dog bites a stranger in the park. You accidentally injure someone with your contents.  S#@! happens and you get sued. We'll hire a lawyer to defend you and pay the costs to get it sorted.</p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder">
                  <h3 class="is-size-4 has-text-weight-bold has-text-centered">Review <mark>changes</mark> and agree?</h3>
                  <div class="check-wrap has-text-centered">
                    <label for="customcheck" class="customcheck">
                      <input type="checkbox" id="customcheck">
                      <span class="customcheck__icon"></span>
                      <span class="customcheck__text has-text-weight-bold">I read and agree with the above changes I made on my policy</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="step4" class="policy__step">
            <div class="box__wrapper">
              <div class="steps__inner">
                <div class="policy__update-holder no__number">
                  <div class="payment__holder">
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
                    <div class="sub-step1">
                      <h3 class="is-size-4 has-text-weight-bold has-text-centered">How do you want to <mark>pay?</mark></h3>
                      <p class="has-text-centered">We will cancel your previous subscription and setup a new subscription with your new payment details.</p>
                      <ul class="pay-options">
                        <li>
                          <label class="customradio">
                            <input type="radio" name="payment" id="paypal">
                            <span class="customradio__check"></span>
                            <span class="customradio__text">Paypal</span>
                            <span class="customradio__image">
                              <img src="/assets/images/payment_paypal.png" alt="Suresy paypal">
                            </span>
                          </label>
                        </li>
                        <li>
                          <label class="customradio">
                            <input type="radio" name="payment" id="cc">
                            <span class="customradio__check"></span>
                            <span class="customradio__text">Credit Card</span>
                            <span class="customradio__image">
                              <img src="/assets/images/payment_cc.png" alt="Suresy paypal">
                            </span>
                          </label>
                        </li>
                      </ul>
                      <div class="button__wrap has-text-centered">
                        <button class="button is-medium has-text-weight-bold is-link" id="proceed_pay">Pay $16/month</button>
                      </div>
                    </div>
                    <div class="sub-step2">
                      <div class="paypal__wrap has-text-centered">
                        <h3 class="is-size-3 has-text-weight-bold">OK Great!, let's setup your <br><mark>Paypal subscription</mark></h3>
                        <p>Just click on the Paypal button below and you will be forwarded to the Paypal website to setup your payment subscription. Once you're done with that, you will forwarded back to the Suresy website to confirm everything is all good to go!</p>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                          <input type="hidden" name="cmd" value="_xclick-subscriptions">
                          <input type="hidden" name="business" value="5JJZZW3KYQVWJ">
                          <input type="hidden" name="lc" value="AU">
                          <input type="hidden" name="item_name" value="Suresy Insurance Premium">
                          <input type="hidden" name="no_note" value="1">
                          <input type="hidden" name="no_shipping" value="1">
                          <input type="hidden" name="rm" value="1">
                          <input type="hidden" name="return" id="paypal_premium_return" value="https://my.suresy.com.au/quote/calculator/success?p=unknown">
                          <input type="hidden" name="src" value="1">
                          <input type="hidden" name="a3" value="1.00" id="paypal_premium_price">
                          <input type="hidden" name="p3" value="1">
                          <input type="hidden" name="t3" value="M">
                          <input type="hidden" name="currency_code" value="AUD">
                          <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
                          <input type="hidden" name="notify_url" id="paypal_premium_notifyurl" value="https://my.suresy.com.au/calc/success?p=unknown">
                          <input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
                          <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
                        </form>
                      </div>
                    </div>
                    <div class="sub-step3">
                      <div class="cc__wrap has-text-centered">
                        <h3 class="is-size-3 has-text-weight-bold">Alright, let's get your payment <br><mark>details setup</mark></h3>
                        <p>Just fill out your credit card details below</p>
                        <div class="field horizontal">
                          <label for="card_name">Name on Card</label>
                          <div class="input__box">
                            <input type="text" class="input" placeholder="Card Holder's Name">
                          </div>
                        </div>
                        <div class="field horizontal">
                          <label for="card_name">Card Number</label>
                          <div class="input__box">
                            <input type="text" class="input" placeholder="Credit Card Number">
                          </div>
                        </div>
                        <div class="columns">
                          <div class="column is-8">
                            <div class="field horizontal has__two">
                              <label for="card_name">Expiration</label>
                              <div class="input__box">
                                <div class="two__col">
                                  <div class="col">
                                    <input type="text" class="input" placeholder="MM" maxlength="2">
                                  </div>
                                  <div class="col">
                                    <input type="text" class="input" placeholder="YYYY" maxlength="4">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="column is-4 ">
                            <div class="field horizontal small__box">
                              <label for="card_name" class="small">CVV</label>
                              <div class="input__box">
                                <input type="text" class="input" placeholder="CVV" maxlength="3">
                              </div>
                            </div>
                          </div>
                        </div>
                        <p class="cc__info">Once you tap the Next button, we will make sure you the credit card you provided is valid. If it is, we will process your first payment of $18 and also setup a monthly subscription that will be billed next on the 2nd of each month.</p>
                        <div class="button__wrap has-text-centered">
                          <a href="#" class="button is-medium has-text-weight-bold is-link">Pay $16/month</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="submit__holder">
            <div class="steps__inner">
              <div class="sub__title">
                <span class="submit-title">Done editing your details?</span>
              </div>
              <div class="btn__wrap">
                <a href="#" class="button is-dark btn__prev"><span class="ico-wrap left"><i class="fas fa-angle-left"></i></span> Previous</a>
                <a href="#" class="button is-link btn__next">Next <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></a>
                <a href="#" class="button is-link btn__submit">I agee, make these changes <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
<!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=AIzaSyD5IwVjvzKIKNKKpZli_sOWmbZoklE3Ojc" async defer></script> -->