<main id="main">
      <div class="top-content">
        <div class="container">
          <div class="box">
            <form action="/profile/update" method="POST" class="profile__form" id="user_details_form">
              <div id="form_message"></div>
              <div class="box__wrapper">
                <div class="steps__inner">
                  <header class="heading">
                    <h2 class="is-size-4 has-text-weight-bold"><mark>Account Details</mark></h2>
                    <div class="btn-holder">
                      <button type="submit" class="button is-link is-small btn__save edit__submit">Save </button>
                      <a href="#" class="button is-link is-small btn__edit">Edit</a>
                    </div>
                  </header>
                  <!-- <div class="columns">
                    <div class="column">
                      <div class="field">
                        <label class="label" for="first-name">First name</label>
                        <div class="control">
                          <input type="text" class="input listener" placeholder="First name" name="f-name" id="first-name" value="<?= $user->first_name ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <label class="label" for="last-name">Last name</label>
                        <div class="control">
                          <input type="text" class="input listener" placeholder="Last name" name="l-name" id="last-name" value="<?= $user->last_name ?>"  required>
                        </div>
                      </div>
                    </div>
                  </div> -->
                  <div class="columns">
                    <div class="column">
                      <div class="field">
                        <label class="label" for="email">Email</label>
                        <div class="control">
                          <input type="email" class="input listener" placeholder="Email" name="email" id="email" value="<?= $user->email ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <label class="label" for="phone">Phone</label>
                        <div class="control">
                          <input type="text" class="input listener" placeholder="Phone number" name="phone" id="phone" value="<?= $user->phone ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box__wrapper">
                <div class="steps__inner">
                  <header class="heading">
                    <h2 class="is-size-4 has-text-weight-bold"><mark>Change Password</mark></h2>
                    <a href="#" class="button is-link is-small btn__edit">Edit</a>
                  </header>
                  <div class="pass__block">
                    <div class="columns">
                      <div class="column">
                        <div class="field">
                          <label class="label" for="new-pass">New Password</label>
                          <p class="pass_info">Password should be minimum 8 character with atleast 1 uppercase, 1 number and 1 special character</p>
                          <div class="control">
                            <input type="password" class="input listener" placeholder="New Password" name="new-pass" id="new-pass">
                          </div>
                        </div>
                      </div>
                      <div class="column">
                        <div class="field">
                          <label class="label" for="re-new-pass">Re-enter New Password</label>
                          <p class="pass_info">&nbsp;</p>
                          <div class="control">
                            <input type="password" class="input listener" placeholder="Re-enter New Password" name="re-new-pass" id="re-new-pass">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="box__wrapper skip__edit">
                <div class="steps__inner">
                  <header class="heading heading__mobile--full">
                    <div class="head-left">
                      <h2 class="is-size-4 has-text-weight-bold"><mark>Address</mark></h2>
                      <span class="head__info">Since policies depend on address you will need to make changes on <a href="policy/">Policy</a> to change address</span>
                    </div>
                    <div class="btn-holder">&nbsp;</div>
                  </header>
                  <div class="columns">
                    <div class="column">
                      <div class="field">
                        <label class="label" for="add-1">Street Address</label>
                        <div class="control">
                          <div class="input">
                            <?= ($user->address_street ? $user->address_street : 'Street Address' ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <label class="label" for="add-2">Street Address (Line 2)</label>
                        <div class="control">
                          <div class="input">
                            <?= ($user->address_street2 ? $user->address_street2 : 'Street Address 2' ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <div class="field">
                        <label class="label" for="city">City</label>
                        <div class="control">
                          <div class="input">
                            <?= ($user->city ? $user->city : 'City' ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <label class="label" for="suburb">Suburb</label>
                        <div class="control">
                          <div class="input">
                            <?= ($user->suburb ? $user->suburb : 'Suburb' ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <div class="field">
                        <label class="label" for="state">State</label>
                        <div class="control">
                          <div class="input">
                            <?php
                              if($user->state) {
                                switch ($user->state) {
                                  case 'act':
                                    echo 'Australian Capital Territory';
                                    break;
                                  case 'nsw':
                                    echo 'New South Wales';
                                    break;
                                  case 'nt':
                                    echo 'Northern Territory';
                                    break;
                                  case 'qld':
                                    echo 'Queensland';
                                    break;
                                  case 'sa':
                                    echo 'South Australia';
                                    break;
                                  case 'tas':
                                    echo 'Tasmania';
                                    break;
                                  case 'vic':
                                    echo 'Victoria';
                                    break;
                                  case 'wa':
                                    echo 'Western Australia';
                                    break;
                                }
                              }else {
                                echo 'State';
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="field">
                        <label class="label" for="postal_code" >Postal Code</label>
                        <div class="control">
                          <div class="input">
                            <?= ($user->postcode ? $user->postcode : 'Postal Code' ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="button-holder">
                <div class="steps__inner">
                  <button type="submit" class="button is-link is-right edit__submit">Save <span class="ico-wrap"><i class="fas fa-angle-right"></i></span></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>