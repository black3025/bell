<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ (!empty($containerNav) ? $containerNav : 'container-fluid') }} d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      © <script>
        document.write(new Date().getFullYear())

      </script>
      , made with ❤️ by PotChie
    </div>
    <div>
      <a href="{{ config('variables.support') ? config('variables.support') : '#' }}" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
    </div>
  </div>
</footer>
<!--/ Footer-->
