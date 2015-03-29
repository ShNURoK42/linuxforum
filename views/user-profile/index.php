<?php

/* @var \app\models\User $user */
?>
<div class="columns">
    <div class="column one-fourth" role="navigation">
        <nav data-pjax="" class="menu">
            <h3 class="menu-heading">Персональные настройки</h3>
            <a data-selected-links="avatar_settings /settings/profile" class="selected js-selected-navigation-item menu-item" href="/settings/profile">Profile</a>
            <a data-selected-links=" /settings/admin" class="js-selected-navigation-item menu-item" href="/settings/admin">Account settings</a>
            <a data-selected-links=" /settings/emails" class="js-selected-navigation-item menu-item" href="/settings/emails">Emails</a>
            <a data-selected-links=" /settings/notifications" class="js-selected-navigation-item menu-item" href="/settings/notifications">Notification center</a>
            <a data-selected-links="user_billing_settings /settings/billing" class="js-selected-navigation-item menu-item" href="/settings/billing">Billing</a>
            <a data-selected-links=" /settings/ssh" class="js-selected-navigation-item menu-item" href="/settings/ssh">SSH keys</a>
            <a data-selected-links=" /settings/security" class="js-selected-navigation-item menu-item" href="/settings/security">Security</a>
            <a data-selected-links="applications_settings /settings/applications" class="js-selected-navigation-item menu-item" href="/settings/applications">Applications</a>
            <a data-selected-links=" /settings/repositories" class="js-selected-navigation-item menu-item" href="/settings/repositories">Repositories</a>
            <a data-selected-links=" /settings/organizations" class="js-selected-navigation-item menu-item" href="/settings/organizations">Organizations</a>
        </nav>
    </div>
    <div class="column three-fourths">
        <div class="boxed-group">
            <h3>Public profile</h3>
            <div class="boxed-group-inner clearfix">
                <form method="post" id="profile_2491495" data-upload-policy-url="/upload/policies/avatars" class="columns js-uploadable-container js-upload-avatar-image is-default" action="/users/ShNURoK42" accept-charset="UTF-8"><div style="margin:0;padding:0;display:inline"><input type="hidden" value="✓" name="utf8"><input type="hidden" value="put" name="_method"><input type="hidden" value="h4mJa97/bCuLKXX9BHRrL9H0E0aVV9aoUftzNi7Ve0a+aDVYM1JMZgjGIuP/qb9ApdS5P1SpgHPhk1M++KE4FA==" name="authenticity_token"></div>

                    <div class="column two-thirds">
                        <dl class="form edit-profile-avatar">
                            <dt><label for="upload-profile-picture">Profile picture</label></dt>
                            <dd class="avatar-upload-container clearfix">
                                <img width="70" height="70" src="https://avatars0.githubusercontent.com/u/2491495?v=3&amp;s=140" data-user="2491495" class="avatar left" alt="@ShNURoK42">
                                <div class="avatar-upload">
                                    <a class="btn button-change-profile-picture" href="#">
                                        <label for="upload-profile-picture">
                                            Upload new picture
                                            <input type="file" class="manual-file-chooser js-manual-file-chooser js-avatar-field" id="upload-profile-picture">
                                        </label>
                                    </a>

                                    <div class="upload-state default">
                                        <p>You can also drag and drop a picture from your computer.</p>
                                    </div>

                                    <div class="upload-state loading">
        <span class="btn disabled">
          <img width="16" height="16" src="https://assets-cdn.github.com/assets/spinners/octocat-spinner-32-e513294efa576953719e4e2de888dd9cf929b7d62ed8d05f25e731d02452ab6c.gif" alt=""> Uploading...
        </span>
                                    </div>

                                    <div class="upload-state text-danger file-empty">
                                        This file is empty.
                                    </div>

                                    <div class="upload-state text-danger too-big">
                                        Please upload a picture smaller than 1 MB.
                                    </div>

                                    <div class="upload-state text-danger bad-dimensions">
                                        Please upload a picture smaller than 10,000x10,000.
                                    </div>

                                    <div class="upload-state text-danger bad-file">
                                        Unfortunately, we only support PNG, GIF, or JPG pictures.
                                    </div>

                                    <div class="upload-state text-danger bad-browser">
                                        This browser doesn't support uploading pictures.
                                    </div>

                                    <div class="upload-state text-danger failed-request">
                                        Something went really wrong and we can't process that picture.
                                    </div>
                                </div> <!-- /.avatar-upload -->
                            </dd>
                        </dl>

                        <dl class="form">
                            <dt><label for="user_profile_name">Name</label></dt>
                            <dd><input type="text" value="Alexandr" size="30" name="user[profile_name]" id="user_profile_name"></dd>
                        </dl>
                        <dl class="form">
                            <dt><label for="user_profile_email">Public email</label></dt>
                            <dd>
                                <select name="user[profile_email]" id="user_profile_email"><option value="">Don't show my email address</option>
                                    <option value="258428@mail.ru">258428@mail.ru</option></select>
                                <p class="note">You can add or remove email addresses in your <a href="/settings/emails">personal email settings </a>.</p>
                            </dd>
                        </dl>
                        <dl class="form">
                            <dt><label for="user_profile_blog">URL</label></dt>
                            <dd><input type="url" value="http://linuxforum.ru" size="30" name="user[profile_blog]" id="user_profile_blog"></dd>
                        </dl>
                        <dl class="form">
                            <dt><label for="user_profile_company">Company</label></dt>
                            <dd><input type="text" value="" size="30" name="user[profile_company]" id="user_profile_company"></dd>
                        </dl>
                        <dl class="form">
                            <dt><label for="user_profile_location">Location</label></dt>
                            <dd><input type="text" value="Kemerovo" size="30" name="user[profile_location]" id="user_profile_location"></dd>
                        </dl>
                        <p><button class="btn btn-primary" type="submit">Update profile</button></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>