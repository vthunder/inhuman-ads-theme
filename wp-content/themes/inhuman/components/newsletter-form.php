<section class="newsletter-section">
  <div class="newsletter-inner">
    <img class="email-envelope" src="<?php tpldir(); ?>/assets/email-envelope.png">
    <div class="stay-informed">
      <h2>Get Email Updates</h2>
      <p>Be the first to learn what's new in the world of Inhuman Ads.</p>
    </div>


    <div class="newsletter" id="newsletter_wrap">
      <form id="newsletter_form" name="newsletter_form" action="https://www.mozilla.org/en-US/newsletter/" method="post">
        <input type="hidden" id="fmt" name="fmt" value="H">
        <input type="hidden" id="newsletters" name="newsletters" value="inhuman">

        <div id="newsletter_errors" class="newsletter_errors"></div>

        <div id="newsletter_email" class="form_group">
          <label for="email" class="form_label">E-mail</label>
          <input type="email" id="email" name="email" class="form_input" required placeholder="YOUR EMAIL HERE" size="30">
        </div>

        <div id="newsletter_privacy" class="form_group form_group-agree">
        </div>
        <div class="form_details">
          <div class="field field-format">
            <label for="id_fmt_0"><input checked="checked" id="id_fmt_0" name="fmt" type="radio" value="H" /> HTML</label><label for="id_fmt_1"><input id="id_fmt_1" name="fmt" type="radio" value="T" /> Text</label>
          </div>
          <input type="checkbox" id="privacy" name="privacy" required>
          <label for="privacy">
            I'm okay with Mozilla handling my info as explained in this <a href="https://www.mozilla.org/privacy/">Privacy Notice</a>.
          </label>
        </div>
        <div id="newsletter_submit">
          <button id="newsletter_submit" type="submit" class="btn btn-success">Sign Up Now</button>
        </div>
      </form>
      <div id="newsletter_thanks" class="newsletter_thanks">
        <h2>Thanks!</h2>
        <p>
          If you haven’t previously confirmed a subscription to a Mozilla-related newsletter you may have to do so.
          Please check your inbox or your spam filter for an email from us.
        </p>
      </div>
    </div>
  </div>
</section>
