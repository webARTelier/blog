<?php include '_html_head.php'; ?>

<body id="blog">



  <!-- navigation -->
  <?php include '_html_navigation.php'; ?>
  <!-- end navigation -->



  <!-- page content -->
  <div class="l-content">



    <!-- post -->
    <div class="c-post">

      <img class="c-post__image" src="images/post_small.jpg"
           srcset="images/post_small.jpg 768w,
                   images/post_medium.jpg 1024w,
                   images/post_large.jpg 1200w"
           sizes="(min-width: 990px) 68vw, 89vw"
           alt="Image">

      <div class="c-post__time">
        <time datetime="2018-11-10T19:24:08+00:00">10.11.2018</time>
        WEB<span class="u-color-primary">ART</span>ELIER
      </div>

      <a href="javascript:;">
        <h1 class="c-post__headline" >Dogs and CSS</h1>
      </a>



      <!-- wrapper meta/post content -->
      <div class="c-post__wrapper">

        <!-- post meta -->
        <div class="c-meta">
          <div class="c-meta__item">
            <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-list"></use></svg>
            <a class="c-meta__link" href="javascript:;">general</a>
          </div>
          <div class="c-meta__item">
            <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-bubble"></use></svg>
            <a class="c-meta__link" href="#target-comment">kommentieren</a>
          </div>
        </div>
        <!-- end post meta -->



        <!-- post content -->
        <div class="c-post__content">

          <div class="c-post__abstract">
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
          </div>

          <div class="c-post__text">
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>


            <div class="c-scrollContainer">
              <pre><code class="c-code">&period;c-pagetitle &lcub;&NewLine;  &commat;include typo-headline&semi;&NewLine;&NewLine;  margin-bottom&colon; 8&percnt;&semi;&NewLine;  padding&colon; 3&percnt;&semi;&NewLine;  max-width&colon; var&lpar;--maxwidth-content&rpar;&semi;&NewLine;&NewLine;  font-size&colon; 20px&semi;&NewLine;  font-weight&colon; 700&semi;&NewLine;  text-transform&colon; uppercase&semi;&NewLine;&NewLine;  background-color&colon; shade&lpar;white&comma; 4&rpar;&semi;&NewLine;&NewLine;  &commat;include vp-nav-desktop &lcub;&NewLine;    padding&colon; 2&percnt;&semi;&NewLine;    font-size&colon; 24px&semi;&NewLine;  &rcub;&NewLine;&rcub;</code></pre>
            </div>

            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
          </div>



          <!-- comments -->
          <div class="l-comments js-shiftFormHome">

            <h3 class="c-comments__title u-spaceTop">Drei Kommentare</h3>



            <!-- comment -->
            <div class="c-comment" data-id="1">
              <div class="c-comment__avatar">
                <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
              </div>

              <div class="c-comment__content">
                <div class="c-comment__author">ocean king royal jelly</div>
                <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
                <div class="c-comment__text js-shiftFormAnchor">
                  <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                  <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
                </div>



                <div class="c-divider c-divider--small"></div>



                <!-- comment -->
                <div class="c-comment" data-id="2">
                  <div class="c-comment__avatar">
                    <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
                  </div>

                  <div class="c-comment__content">

                    <div class="c-comment__author">ocean king royal jelly</div>
                    <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
                    <div class="c-comment__text js-shiftFormAnchor">
                      <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                      <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
                    </div>

                    <div class="c-divider c-divider--small"></div>



                    <!-- comment -->
                    <div class="c-comment" data-id="3">
                      <div class="c-comment__avatar">
                        <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
                      </div>

                      <div class="c-comment__content">

                        <div class="c-comment__author">ocean king royal jelly</div>
                        <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
                        <div class="c-comment__text js-shiftFormAnchor">
                          <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                          <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
                        </div>

                      </div>
                    </div>
                    <!-- end comment -->

                  </div>
                </div>
                <!-- end comment -->

              </div>
            </div>
            <!-- end comment -->



            <!-- comment form -->
            <form id="target-comment" class="js-prefill js-shiftableForm">

              <div class="c-divider c-divider--small"></div>

              <h3 class="c-comments__title">
                Kommentar&nbsp;
                <span class="c-button c-button--small is-hidden js-shiftbackForm">cancel</span>
              </h3>

              <label class="c-label" for="input_comment">Kommentar*</label>
              <textarea id="input_comment" class="c-input" name="input_comment" cols="45" rows="8" maxlength="65525" required></textarea>

              <label class="c-label" for="input_name">Name*</label>
              <input id="input_name" class="c-input" name="input_name" required>

              <label class="c-label" for="input_email">Email*</label>
              <input id="input_email" class="c-input" name="input_email" required>

              <label class="c-label" for="input_website">Website</label>
              <input id="input_website" class="c-input" name="input_website">

              <input id="input_replyTo" name="antwortenTo" value="">
              <input id="input_remark" class="c-input" name="input_remark">

              <button class="c-button js-submit">
                <span class="c-button__flex">
                  <span class="c-button__text">abschicken</span>
                  <svg class="c-button__icon"><use xlink:href="images/icons.svg#icon-plane"></use></svg>
                </span>
              </button>

            </form>
            <!-- end comment form -->

          </div>
          <!-- end comments -->

        </div>
        <!-- end post content -->

      </div>
      <!-- end wrapper meta/post content -->

    </div>
    <!-- end post -->

  </div>
  <!-- end page content -->



  <!-- page footer -->
  <?php include '_html_footer.php'; ?>
  <!-- end page footer -->



</body>
</html>
