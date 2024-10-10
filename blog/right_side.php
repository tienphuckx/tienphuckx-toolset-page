<section id="right-area">

    <div class="avatar">
        <img src="https://avatars.githubusercontent.com/u/67540145?v=4" alt="Phuc" />
    </div>

    <div class="list-tools">
        <ul>
            <li>
                <a href="#">My File management</a>
            </li>
            <li>
                <a href="#">Convert Word to PDF</a>
            </li>
            <li>
                <a href="#">Hiding message to file</a>
            </li>
            <li>
                <a href="#">USD/AUD/... to VND</a>
            </li>
            <li>
                <a href="#">Perpetual calendar</a>
            </li>
            <li>
                <a href="#">Anonymous chat room</a>
            </li>
            <li>
                <a href="#">Save your own todo note (New: announce via MS)</a>
            </li>
            <li>
                <a href="#">List of powerful tool links</a>
            </li>
            <li>
                <a href="#">Quick send email to me</a>
            </li>
        </ul>
    </div>

    <!-- Dynamic tags section -->
    <?php if (!empty($right_side_tags)) { ?>
        <div class="tags-section">
            <?php foreach ($right_side_tags as $tag) { ?>
                <span class="badge"><?php echo htmlspecialchars($tag); ?></span>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No tags available.</p>
    <?php } ?>
</section>
