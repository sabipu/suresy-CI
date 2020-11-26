<main id="main">
  <div class="top-content">
    <div class="container">
      <div class="columns">
        <div class="column">
          <div class="box">
            <form action="/claims/make/new" method="post" id="make_claim_form">
              <div class="claim__steps" id="claim_steps">
                <!-- Step User Info -->
                <div class="claim__step steps__inner step1 active__step" id="claim_step1">
                  <div class="is-hidde">
                    <div class="general__heading">
                      <h3 class="is-size-4"><mark>Lets get started ...</mark></h3>
                      <h4 class="has-text-weight-bold is-size-3 claim__heading">What kind of <mark>claim</mark> do you want to make?</h4>
                    </div>
                    <!-- <select name="claim_type">
                      <option value="T">Theft</option>
                      <option value="F">Fire</option>
                      <option value="D">Accidental Damage</option>
                    </select> -->
                    <ul class="claim__list">
                      <li>
                        <label class="claim__check">
                          <input type="radio" class="fire" name="damage_type">
                          <span class="claim__check-wrap">
                            <div class="img__wrap">
                              <img src="../../../assets/images/fire.svg" width="120" alt="Suresy" class="normal">
                              <img src="../../../assets/images/fire-blue.svg" width="120" alt="Suresy" class="check-active">
                              <span class="check__tick">&nbsp;</span>
                            </div>
                            <span class="title">Fire</span>
                          </span>
                        </label>
                      </li>
                      <li>
                        <label class="claim__check">
                          <input type="radio" class="theft" name="damage_type">
                          <span class="claim__check-wrap">
                            <div class="img__wrap">
                              <img src="../../../assets/images/thief.svg" width="120" alt="Suresy" class="normal">
                              <img src="../../../assets/images/thief-blue.svg" width="120" alt="Suresy" class="check-active">
                              <span class="check__tick">&nbsp;</span>
                            </div>
                            <span class="title">Theft</span>
                          </span>
                        </label>
                      </li>
                      <li>
                        <label class="claim__check">
                          <input type="radio" class="damage" name="damage_type">
                          <span class="claim__check-wrap">
                            <div class="img__wrap">
                              <img src="../../../assets/images/damage.svg" width="78" alt="Suresy" class="normal">
                              <img src="../../../assets/images/damage-blue.svg" width="78" alt="Suresy" class="check-active">
                              <span class="check__tick">&nbsp;</span>
                            </div>
                            <span class="title">Accidental Damage</span>
                          </span>
                        </label>
                      </li>
                    </ul>
                  </div>
                  <div class="when__checked is-clearfix">
                    <div class="tab fire__checked">
                      <ul class="claim__list">
                        <li>
                          <label class="claim__check">
                            <input type="radio" name="damage_tab">
                            <span class="claim__check-wrap">
                              <div class="img__wrap">
                                <img src="../../../assets/images/fire.svg" width="120" alt="Suresy" class="normal">
                                <img src="../../../assets/images/fire-blue.svg" width="120" alt="Suresy" class="check-active">
                                <span class="check__tick">&nbsp;</span>
                              </div>
                              <span class="title">Fire</span>
                            </span>
                          </label>
                        </li>
                      </ul>
                      <div class="text__holder">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Lets get started ...</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Please make sure you have the following</h4>
                        </div>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary</p>
                        <ul class="check__list">
                          <li>Police Reports</li>
                          <li>Witness Statements</li>
                          <li>Photos of damage</li>
                          <li>Proof of Ownership / Purchase</li>
                        </ul>
                      </div>
                    </div>
                    <div class="tab theft__checked">
                      <ul class="claim__list">
                        <li>
                          <label class="claim__check">
                            <input type="radio" name="damage_tab">
                            <span class="claim__check-wrap">
                              <div class="img__wrap">
                                <img src="../../../assets/images/thief.svg" width="120" alt="Suresy" class="normal">
                                <img src="../../../assets/images/thief-blue.svg" width="120" alt="Suresy" class="check-active">
                                <span class="check__tick">&nbsp;</span>
                              </div>
                              <span class="title">Theft</span>
                            </span>
                          </label>
                        </li>
                      </ul>
                      <div class="text__holder">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Lets get started ...</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Please make sure you have the following</h4>
                        </div>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary</p>
                        <ul class="check__list">
                          <li>Police Reports</li>
                          <li>Witness Statements</li>
                          <li>Photos of damage</li>
                          <li>Proof of Ownership / Purchase</li>
                        </ul>
                      </div>
                    </div>
                    <div class="tab damage__checked">
                      <ul class="claim__list">
                        <li>
                          <label class="claim__check">
                            <input type="radio" name="damage_tab">
                            <span class="claim__check-wrap">
                              <div class="img__wrap">
                                <img src="../../../assets/images/damage.svg" width="78" alt="Suresy" class="normal">
                                <img src="../../../assets/images/damage-blue.svg" width="78" alt="Suresy" class="check-active">
                                <span class="check__tick">&nbsp;</span>
                              </div>
                              <span class="title">Accidental Damage</span>
                            </span>
                          </label>
                        </li>
                      </ul>
                      <div class="text__holder">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Lets get started ...</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Please make sure you have the following</h4>
                        </div>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary</p>
                        <ul class="check__list">
                          <li>Police Reports</li>
                          <li>Witness Statements</li>
                          <li>Photos of damage</li>
                          <li>Proof of Ownership / Purchase</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Step Basic Incident Info -->
                <div class="claim__step steps__inner step2" id="claim_step2">
                  <div class="general__heading">
                    <h3 class="is-size-4"><mark>Step 2</mark></h3>
                    <h4 class="has-text-weight-bold is-size-3 claim__heading">Tell us about what <mark>happened</mark>!</h4>
                  </div>
                  <div class="message__holder">
                    <div class="field">
                      <textarea  class="textarea" rows="6" name="claim_description" id="claim_description" placeholder="Please provide details about the incident"></textarea>
                    </div>
                  </div>
                  <div class="time__holder">
                    <div class="columns">
                      <div class="column is-one-third">
                        <span class="time__title">When did this happen?</span>
                      </div>
                      <div class="column is-two-third">
                        <div class="columns no__bottom">
                          <div class="column">
                            <div class="field">
                              <p class="control has-icons-left">
                                <input type="date" class="input datetime date" placeholder="What date did this happen?" name="claim_incident_date" id="claim_incident_date" value="<?= date('Y-m-d', time()) ?>" />
                                <span class="icon is-left">
                                  <i class="fas fa-calendar"></i>
                                </span>
                              </p>
                            </div>
                          </div>
                          <div class="column">
                            <div class="field">
                              <p class="control has-icons-left">
                                <input type="time" class="input datetime time" placeholder="What time?" name="claim_incident_time" id="claim_incident_time" value="<?= date('H:i:s', time()) ?>" />
                                <span class="icon is-left">
                                  <i class="fas fa-clock"></i>
                                </span>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Step Witnesses -->
                <div class="claim__step steps__inner step3" id="claim_step3">
                  <div class="columns">
                    <div class="column">
                      <div id="claim_witness_field">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Step 3</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Who witnessed the <mark>incident</mark>?</h4>
                        </div>
                        <div class="field">
                          <input type="text" class="input ignore-input" placeholder="Witness Name" name="claim_witness_name" id="claim_witness_name" />
                        </div>
                        <div class="field">
                          <p class="control has-icons-left">
                            <input type="text" class="input ignore-input" placeholder="Witness Phone" name="claim_witness_phone" id="claim_witness_phone" />
                            <span class="icon is-small is-left">
                              <i class="fas fa-phone"></i>
                            </span>
                          </p>
                        </div>
                        <h4 class="has-text-weight-bold is-size-4 claim__heading--small">What type of witness is this?</h4>
                        <div class="field">
                          <div class="select">
                            <select name="claim_witness_type ignore-input" id="claim_witness_type">
                              <option disabled="disabled" selected="selected">Pick One...</option>
                              <option>Neighbour</option>
                              <option>Police</option>
                              <option>Fire Dept</option>
                              <option>Witness</option>
                            </select>
                          </div>
                        </div>
                        <div class="field">
                          <button type="button" id="claim_add_witness" class="button is-link">Add Witness <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="info__right">
                        <h3 class="is-size-4"><mark>Your Witnesses</mark></h3>
                        <div id="incident_witnesses"></div>
                        <script id="incident_witness_template" type="x-tmpl-mustache">
                          <div class="incident__wrap" data-item='{{num}}'>
                            <a class="incident_witness_remove delete is-medium" href="#"><span></span></a>
                            <span class="incident_witness_type">{{type}}:</span>
                            <strong class="incident_witness_name">{{name}}</strong>
                            <span class="incident_witness_phone"><i class="fas fa-phone"></i>{{phone}}</span>
                          </div>
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Step Items damaged -->
                <div class="claim__step steps__inner step4" id="claim_step4">
                  <div class="columns">
                    <div class="column">
                      <div id="claim_items">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Step 4</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">What was stolen / damaged?</h4>
                        </div>
                        <div class="field">
                          <input type="text" class="input ignore-input" placeholder="Item name" name="claim_item_name" id="claim_item_name" />
                        </div>
                        <div class="field">
                          <p class="control has-icons-left">
                            <input type="text" class="input ignore-input" placeholder="Item price (in AUD)" name="claim_item_price" id="claim_item_price" />
                            <span class="icon is-small is-left">
                              <i class="fas fa-dollar-sign"></i>
                            </span>
                          </p>
                      </div>
                      </div>
                      <h4 class="has-text-weight-bold is-size-4 claim__heading--small">When and where did you buy it?</h4>
                      <div class="field">
                        <input type="text" class="input ignore-input" placeholder="When and where did you buy it?" name="claim_item_when" id="claim_item_when" />
                      </div>
                      <div class="field">
                        <button type="button" id="claim_another_item" class="button is-link">Report item <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                      </div>
                    </div>
                    <div class="column">
                      <div class="info__right">
                        <h3 class="is-size-4"><mark>Claimed Items</mark></h3>
                        <div id="incident_items"></div>
                        <script id="incident_item_template" type="x-tmpl-mustache">
                          <div class="incident__wrap" data-item='{{num}}'>
                            <a class="incident_item_remove delete is-medium" href="#"><span></span></a>
                            <strong class="incident_item_name">{{name}}:</strong>
                            <span class="incident_item_price">${{price}}</span>
                            <span class="incident_item_when">{{when}}</span>
                          </div>
                        </script>
                      </div>
                    </div>
                  </div>
                </div> 
                <!-- Step Files -->       
                <div class="claim__step steps__inner step5" id="claim_step5">
                  <div class="columns">
                    <div class="column">
                      <div id="claim_files">
                        <div class="general__heading">
                          <h3 class="is-size-4"><mark>Step 5</mark></h3>
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Upload files</h4>
                        </div>
                        <div class="field">
                          <div class="file">
                            <label class="file-label">
                              <input class="file-input ignore-input" type="file" name="claim_doc" id="claim_doc" />
                              <span class="file-cta">
                                <span class="file-icon">
                                  <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                  Choose a file…
                                </span>
                              </span>
                            </label>
                          </div>
                        </div>
                        <div class="field">
                          <div class="select">
                            <select name="claim_doc_type" id="claim_doc_type" class=" ignore-input">
                              <option>Police Report</option>
                              <option>Fire Dept Report</option>
                              <option>Item Receipt</option>
                              <option>Photo of Damage</option>
                              <option>Document</option>
                              <option>Other...</option>
                            </select>
                          </div>
                        </div>
                        <h4 class="has-text-weight-bold is-size-4 claim__heading--small">File Description</h4>
                        <div class="field">
                          <textarea name="claim_doc_description" placeholder="Describe this file" id="claim_doc_description"  class="textarea ignore-input" rows="2"></textarea>
                        </div>
                        <div class="field">
                          <div id="progress-wrp">
                              <div class="progress-bar"></div>
                              <div class="status">0%</div>
                          </div>
                        </div>
                        <div class="field">
                          <button type="button" id="claim_another_file" class="button is-link">Upload File <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="info__right">
                        <h3 class="is-size-4"><mark>Uploaded files</mark></h3>
                        <div id="incident_files_wrapper">
                          <div id="incident_files"></div>
                          <script id="incident_file_template" type="x-tmpl-mustache">
                            <div class="incident__wrap" data-item='{{num}}'>
                              <a class="incident_witness_remove delete is-medium" href="#"><span></span></a>
                              <strong class="incident_file_name">{{file}}</strong>
                              <span class="incident_file_type">{{type}}</span>
                            </div>
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Confirm & Submit -->
                <div class="claim__step step6" id="claim_step6">
                  <div class="done__wrapper">
                    <div class="steps__inner">
                      <div class="columns is-centered">
                        <div class="column is-half has-text-centered">
                          <h4 class="has-text-weight-bold is-size-3 claim__heading">Almost Done!</h4>
                          <p>Ok, that’s all the info we need. All you need to do now is review your claim below to make sure it’s right, and if everything is correct, press <strong>“Submit claim”</strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="claim__info">
                    <div class="steps__inner">
                      <div class="top-wrapper">
                        <dl class="claim__head">
                          <dt>Claim</dt>
                          <dd>Theft</dd>
                        </dl>
                        <dl class="claim__head">
                          <dt>Date of Incident</dt>
                          <dd><time>June 3, 2018  11:33 pm</time></dd>
                        </dl>
                      </div>
                      <h3 class="is-size-4 happen__heading"><mark>What happened?</mark></h3>
                      <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                      <p>It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                    </div>
                  </div>
                  <div class="total__info">
                    <div class="steps__inner">
                      <h3 class="is-size-4"><mark>Items Your Claiming</mark></h3>
                      <ul class="items-list">
                        <li>
                          <div class="txt-wrap">
                            <span class="price">$654</span>
                            <span class="name">Laptop</span>
                          </div>
                          <span class="time">PURCHASED April 16, 2018</span>
                        </li>
                        <li>
                          <div class="txt-wrap">
                            <span class="price">$312</span>
                            <span class="name">Camera</span>
                          </div>
                          <span class="time">PURCHASED April 16, 2018</span>
                        </li>
                      </ul>
                      <div class="total-holder">
                        <h3 class="is-size-4"><mark>Items Your Claiming</mark></h3>
                        <span class="total">$1,200</span>
                      </div>
                    </div>
                  </div>
                  <div class="witness__info">
                    <div class="steps__inner">
                      <h3 class="is-size-4"><mark>Who witnessed the incident?</mark></h3>
                      <ul class="witness-list">
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-user.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Officer Bob</span>
                            <span class="post">Police Officer</span>
                            <span class="phone">0422 188 213</span>
                          </div>
                        </li>
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-user.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Officer Bob</span>
                            <span class="post">Police Officer</span>
                            <span class="phone">0422 188 213</span>
                          </div>
                        </li>
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-user.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Officer Bob</span>
                            <span class="post">Police Officer</span>
                            <span class="phone">0422 188 213</span>
                          </div>
                        </li>
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-user.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Officer Bob</span>
                            <span class="post">Police Officer</span>
                            <span class="phone">0422 188 213</span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="files__info">
                    <div class="steps__inner">
                      <h3 class="is-size-4"><mark>Uploaded Files</mark></h3>
                      <ul class="witness-list file-list">
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-photo.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Photo</span>
                            <span class="post">23kb - laptop damage.jpg</span>
                          </div>
                        </li>
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-report.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Photo</span>
                            <span class="post">23kb - laptop damage.jpg</span>
                          </div>
                        </li>
                        <li>
                          <div class="img__wrap">
                            <img src="../../../assets/images/ico-receipt.png" alt="Suresy">
                          </div>
                          <div class="text-wrap">
                            <span class="name">Photo</span>
                            <span class="post">23kb - laptop damage.jpg</span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="steps__buttons is-clearfix steps__inner">
                <button type="button" class="button is-dark" id="claim_prev_step" style="display:none;"><span class="ico-wrap left"><i class="fas fa-angle-left"></i></span> Back</button>
                <button type="submit" class="button is-link right-side" id="claim_submit" style="display:none;">Submit Claim <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                <button type="button" class="button is-link right-side" id="claim_next_step">Next <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
              </div>
            </form>
            <div id="claim_submitted" style="display:none;">
              <h2>Thank you. Your Claim was submitted.</h2>
              <p>We've just emailed you a confirmation of receiving your claim. We will contact you as soon as we review your claim and let you know what the next steps are.</p>
              <a href="/dashboard" class="btn is-large">Back to Dashboard</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>