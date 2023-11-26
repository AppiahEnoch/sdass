 <nav id="home-nav"  class="navbar navbar-dark navbar-expand-lg bg-color ">
  <div class="container-fluid bg-white buttom-border bg-color">
    <a class="navbar-brand m-0" href="#">
      <img class="img-fluid logo" src="devimage/16.jpg" alt="school logo" />
    </a>

    <a  onclick="showWrapper4(['wrapper2'], 'wrapper', 20);"    class="nav-link  navbar-toggler ae-large-only"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
           
    <button  class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
   
    <div class="collapse navbar-collapse dropdown-bg mb-0" id="navbarNavDropdown">
      <ul class="navbar-nav d-flex w-100 justify-content-between">
    

      <li>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><i class="fa fa-book pe-2" aria-hidden="true"></i>public notice</a>
           
            </li>
        
          </ul>
        </li>
    

        <li >
          <ul class="navbar-nav">
            <li class="nav-item">
              <a   onclick="showWrapper4(['wrapper1'], 'wrapper', 20);"  id="register" class="nav-link " aria-current="page" href="#">   <i class="fa fa-user-plus" aria-hidden="true"></i>     Register</a>
           
            </li>
            <li class="nav-item">
              <a    onclick="showWrapper4(['wrapper2'], 'wrapper', 20);" id="login2" class="nav-link" aria-current="page" href="#"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
           
            </li>
        
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>