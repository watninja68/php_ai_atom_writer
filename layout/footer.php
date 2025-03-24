<script src="scripts/script.js"></script>
 


<!-- JavaScript for Dynamic Video Loading -->
 <script>
        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', function () {
                let videoSrc = this.getAttribute('data-video');
                document.getElementById('videoPlayer').src = videoSrc;
            });
        });
        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', () => {
                window.scrollTo({ top: 70, behavior: 'smooth' });
            });
        });
    </script>




    <!-- // Function to copy referral link -->
    <script>
    function copyReferralLink() {
      const referralLink = document.getElementById('referral-link');
      referralLink.select();
      document.execCommand('copy');
      alert('Referral link copied to clipboard!');
    }
  </script>
</body>

</html>