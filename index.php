<!DOCTYPE html>
<html lang="en">

<head>
  <title>NewGradNomad</title>
  <meta charset="utf-8">
  <link rel="icon" href="./icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./style/NavBar.css" rel="stylesheet">
  <link href="./style/HeroSection.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./pages/scripts/index.js"></script>
</head>

<body>
  <nav class="green-nav navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid"><a href="./index.php" class="navbar-brand">newgradnomad.com</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div class="ms-auto navbar-nav">
            <a class="nav-links nav-link" href="./pages/PostAJob.php">
              <button type="button" class="button btn btn-primary"><strong>Post a Job</strong></button>
            </a>
            <a class="nav-links nav-link" href="./index.php">
              <button type="button" class="button-hide btn btn-primary"><strong>Home</strong></button>
            </a>
            <!--             <div class="button-hide nav-links mt-auto mb-auto show dropdown">
              <button data-bs-toggle="dropdown" type="button" aria-expanded="false" class="dropdown-toggle btn btn-button-hide"><strong>Community</strong></button>
              <div aria-labelledby="dropdown" data-bs-popper="static" class="dropdown-menu">
                <a target="_blank" href="https://discord.gg/khfQcbtHw8" class="nav-links dropdown-item"><button type="button" class="button-hide btn btn-primary"><strong>Discord</strong></button></a>
                <a data-bs-toggle="modal" data-bs-target="#newsletterModal" class="nav-links dropdown-item"><button type="button" class="button-hide btn btn-primary"><strong>Newsletter</strong></button></a>
              </div>
            </div> -->
            <a class="nav-links nav-link" href="./pages/about.php">
              <button type="button" class="button-hide btn btn-primary"><strong>About</strong></button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="text-center hero-container container-fluid">
    <h1 class="fs-1 text-center">Find Remote New Grad Jobs</h1>
    <p class="fs-4 lead text-center">The best place for new graduates &amp; entry-level talent to find remote work.</p>
    <a role="button" href="./pages/PostAJob.php" class=" btn btn-lg mx-1 mb-3 btn btn-light">Post a Job</a>
    <!--     <a role="button" href="./NewGradPrograms.php" class=" btn btn-lg mx-1 mb-3 btn btn-light">New Grad Programs</a>     -->
  </div>
  <form class="">
    <label class="text-center mt-4 form-label" style="width: 100%;">
      <h4>Search Remote Jobs</h4>
    </label>
    <div class="mt-2 d-flex align-items-center justify-content-center">
      <Select id="positionType" name="positionType" class="form-select" style="width:300px;">
        <option value=""></option>
        <option value="Software Development">Software Development</option>
        <option value="Customer Support">Customer Support</option>
        <option value="Sales">Sales</option>
        <option value="IT">IT</option>
        <option value="Writing">Writing</option>
        <option value="Human Resource">Human Resource</option>
        <option value="Design">Design</option>
        <option value="Recruiter">Recruiter</option>
      </select>
      <button type="submit" class="ms-4 button btn btn-primary"><strong>Submit</strong></button>
    </div>

  </form>

  <div class="modal fade" id="newsletterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title h4">Newsletter Signup</div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Signing up for the newsletter will enable you to get notified via email when a new job listing is posted.</p>
          <form novalidate="">
            <div class="mb-3"><label class="form-label">Email address</label>
              <div class="input-group">
                <input required="" placeholder="name@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" class="form-control">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
      </div>
    </div>
  </div>

</body>

<footer id="footer"></footer>

</html>