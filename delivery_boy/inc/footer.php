                        <div class="row">
                            <div class="col-md-12"> <hr>
                                <div class="copyright">
                                    <p>Copyright © 2020. Developed By <a href="https://mithu.epizy.com" target="blank">Mithu</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- assets/Vendor JS       -->
    <script src="assets/vendor/slick/slick.min.js">
    </script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/vendor/animsition/animsition.min.js"></script>
    <!-- <script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="assets/vendor/circle-progress/circle-progress.min.js"></script> -->
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <!-- <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script> -->
    <script src="assets/vendor/select2/select2.min.js">
    </script>
    <!-- CKEditor & Datatables CDN -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>

    <!-- Main JS-->
    <script src="assets/js/main.js"></script>
    <script src="./ajax.js"></script>
    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
        } );

        ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                        console.log( editor );
                } )
                .catch( error => {
                        console.error( error );
            } ); 
    </script>
</body>

</html>
<!-- end document-->