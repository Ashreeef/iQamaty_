<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Learn more about iQamaty and the passionate team behind it. Designed to make dorm life better."
    />
    <meta
      name="keywords"
      content="about, dormitory management, team, iQamaty"
    />

    <title>About iQamaty</title>

    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/iQamaty_10/public/css/about.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />

  </head>

  <body>
    <?php include 'partials/nav.php'; ?>

    <div class="about-section">
      <div class="about-hero">
        <h1>About iQamaty</h1>
        <p>
          At iQamaty, we simplify dormitory management. Built by students, for
          students, we’re here to make your dorm life stress-free.
        </p>
        <a href="/iQamaty_10/views/auth/auth.php" class="cta-button">Join Us Today</a>
      </div>

      <div class="highlight-section">
        <div class="highlight-card">
          <i class="ri-bell-line"></i>
          <h3>Announcements</h3>
          <p>
            Stay updated with the latest dormitory news, from events to critical
            notices.
          </p>
        </div>
        <div class="highlight-card">
          <i class="ri-calendar-line"></i>
          <h3>Events</h3>
          <p>
            Register for exciting events happening in your dorm community
            with just one click.
          </p>
        </div>
        <div class="highlight-card">
          <i class="ri-tools-line"></i>
          <h3>Maintenance</h3>
          <p>
            Report issues and track repairs to keep your dorm running smoothly.
          </p>
        </div>
      </div>

      <div class="team-section">
        <h2>Meet the Founders</h2>
        <div class="team-grid">
          <!-- Founder 1 -->
          <div class="team-card">
            <div class="team-card-image">
              <img
                src="/iQamaty_10/public/images/ashref.png"
                alt="BERBAOUI Ashref"
              />
              <div class="social-links">
                <a href="https://github.com/Ashreeef"><i class="ri-github-fill"></i></a>
                <a href="https://www.linkedin.com/in/ashref-berbaoui-660070287/"><i class="ri-linkedin-fill"></i></a>
              </div>
            </div>
            <h3>BERBAOUI Ashref</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni repudiandae quisquam maiores perferendis.
            </p>
          </div>
          <!-- Founder 2 -->
          <div class="team-card">
            <div class="team-card-image">
              <img
                src="/iQamaty_10/public/images/profile_placeholder.png"
                alt="Founder Two"
              />
              <div class="social-links">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
                <a href="#"><i class="ri-linkedin-fill"></i></a>
              </div>
            </div>
            <h3>Founder Two</h3>
            <p>
              Backend architect ensuring secure, scalable solutions to keep campus life running without a hitch.
            </p>
          </div>
          <!-- Founder 3 -->
          <div class="team-card">
            <div class="team-card-image">
              <img
                src="/iQamaty_10/public/images/profile_placeholder.png"
                alt="Founder Three"
              />
              <div class="social-links">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
                <a href="#"><i class="ri-linkedin-fill"></i></a>
              </div>
            </div>
            <h3>Founder Three</h3>
            <p>
              Front-end designer crafting beautiful, intuitive experiences that make iQamaty a joy to use.
            </p>
          </div>
          <!-- Founder 4 -->
          <div class="team-card">
            <div class="team-card-image">
              <img
                src="/iQamaty_10/public/images/profile_placeholder.png"
                alt="Founder Four"
              />
              <div class="social-links">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
                <a href="#"><i class="ri-linkedin-fill"></i></a>
              </div>
            </div>
            <h3>Founder Four</h3>
            <p>
              Data analyst continuously refining iQamaty based on real student insights and feedback.
            </p>
          </div>
        </div>
      </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="/iQamaty_10/public/js/main.js"></script>
    <script>
      const sr = ScrollReveal({
        origin: 'bottom', 
        distance: '50px', 
        duration: 1000,   
        delay: 200,      
        reset: false,   
      });

      sr.reveal('.about-hero', { origin: 'top', distance: '100px', duration: 1200 });
      sr.reveal('.highlight-card', { interval: 200 }); 
      sr.reveal('.team-card', { interval: 200, origin: 'bottom' });
    </script>

  </body>
</html>
