<?php

if (is_array($posts) && count($posts) > 0) {
    foreach ($posts as $post) {
        ?>
        <div class="a-post">
            <div class="post-title">
                <a class="" href="post.php?id=<?php echo $post['post_content_id']; ?>">
                    <h3 class="title"><?php echo htmlspecialchars($post['title']); ?></h3>
                </a>
            </div>

            <p class="card-text"><?php echo htmlspecialchars($post['short_intro']); ?></p>

            <div class="post-info">
                <div class="tags">
                    <?php if (!empty($post['tags'])) { ?>
                        <?php foreach ($post['tags'] as $tag) { ?>
                            <span class="tag-badge"><?php echo htmlspecialchars($tag); ?></span>
                        <?php } ?>
                    <?php } ?>
                </div>

                <div class="social">
                    <span class="read">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="blue" class="bi bi-eye-fill"
                            viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                        <span>307</span>
                    </span>

                    <span class="love">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="red" class="bi bi-heart-fill"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                        </svg>
                        <span>2k</span>
                    </span>

                    <span class="comment">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="green"
                            class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                        <span>(150)</span>
                    </span>

                </div>
            </div>
        </div>

        <?php
    }
} else {
    echo '<p>No posts available.</p>';
}
?>