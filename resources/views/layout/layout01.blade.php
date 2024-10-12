<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
  <head>
    @include('layout.part.header')
  </head>


  <!-- Body -->
  <body>

    <!-- Page loading spinner -->
    <div class="page-loading active">
      <div class="page-loading-inner">
        <div class="page-spinner"></div>
        <span>Loading...</span>
      </div>
    </div> 

    <!-- Page wrapper -->
    <main class="page-wrapper">

      <!-- Navbar. Remove 'fixed-top' class to make the navigation bar scrollable with the page -->
      @include('layout.part.topbar01')


      <!-- Page container -->
      @yield('content')

    </main>

    <!-- modal -->
    @include('layout.part.modal')

    
    <!-- Footer-->
    @include('layout.part.footer')
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js" integrity="sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js" integrity="sha512-9pm50HHbDIEyz2RV/g2tn1ZbBdiTlgV7FwcQhIhvykX6qbQitydd6rF19iLmOqmJVUYq90VL2HiIUHjUMQA5fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
  </body>
</html>
