<?php
/**
 * Template Name: About Us Page
 * 
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<main class="about-us-page">
    <?php while ( have_posts() ) : the_post(); ?>
    
    <!-- Hero Section -->
    <section class="about-hero-section">
        <div class="about-hero-grid">
            <!-- Left Content -->
            <div class="about-hero-content">
                <div class="about-hero-inner">
                    <span class="about-hero-label">
                        <?php 
                        $founded_year = function_exists( 'of_get_option' ) ? of_get_option( 'founded_year' ) : '2014';
                        echo esc_html( 'Est. ' . $founded_year . ' — Dubai, UAE' ); 
                        ?>
                    </span>
                    <h1 class="about-hero-title">
                        Crafting <span class="serif-text">Visual Excellence</span> In The Heart Of Dubai.
                    </h1>
                    <p class="about-hero-description">
                        <?php 
                        if ( function_exists( 'get_field' ) && get_field( 'hero_description' ) ) {
                            the_field( 'hero_description' );
                        } else {
                            esc_html_e( 'We bridge the gap between creative vision and physical reality. From large-scale architectural signage to premium bespoke prints, we define the aesthetic landscape of the region\'s most ambitious brands.', 'efficient-modern' );
                        }
                        ?>
                    </p>
                    <div class="about-hero-divider">
                        <div class="divider-line"></div>
                        <span class="divider-text"><?php esc_html_e( 'Driven by Precision', 'efficient-modern' ); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="about-hero-image">
                <?php 
                $hero_image = function_exists( 'get_field' ) ? get_field( 'about_hero_image' ) : '';
                if ( $hero_image ) :
                ?>
                    <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Creative team collaborating', 'efficient-modern' ); ?>">
                <?php else : ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'Creative team collaborating', 'efficient-modern' ); ?>">
                <?php endif; ?>
                <div class="about-hero-overlay"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="about-stats-section">
        <div class="container">
            <div class="about-stats-grid">
                <div class="stat-item">
                    <h2 class="stat-number">10+</h2>
                    <p class="stat-label"><?php esc_html_e( 'Years of Experience', 'efficient-modern' ); ?></p>
                </div>
                <div class="stat-item">
                    <h2 class="stat-number">500+</h2>
                    <p class="stat-label"><?php esc_html_e( 'Corporate Clients', 'efficient-modern' ); ?></p>
                </div>
                <div class="stat-item">
                    <h2 class="stat-number">1M+</h2>
                    <p class="stat-label"><?php esc_html_e( 'Prints Delivered', 'efficient-modern' ); ?></p>
                </div>
                <div class="stat-item">
                    <h2 class="stat-number">24/7</h2>
                    <p class="stat-label"><?php esc_html_e( 'Client Support', 'efficient-modern' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="about-philosophy-section">
        <div class="about-philosophy-container">
            <div class="about-philosophy-grid">
                <div class="philosophy-heading">
                    <h3 class="philosophy-title">
                        <?php esc_html_e( 'Our philosophy is simple:', 'efficient-modern' ); ?> 
                        <span class="philosophy-highlight"><?php esc_html_e( 'Quality is not an act, it\'s a habit.', 'efficient-modern' ); ?></span>
                    </h3>
                </div>
                <div class="philosophy-content">
                    <?php if ( function_exists( 'get_field' ) && get_field( 'philosophy_content' ) ) : ?>
                        <?php the_field( 'philosophy_content' ); ?>
                    <?php else : ?>
                        <p>
                            Founded in the bustling industrial hubs of Dubai, Efficient Advertising began as a small boutique workshop with a single wide-format printer and a grand vision. Today, we stand as a leader in the advertising and printing industry, serving global brands across the UAE.
                        </p>
                        <p>
                            Our facility houses the latest European printing technology, ensuring that every hue, every line, and every texture meets the highest international standards. We don't just print; we consult, design, and install, providing an end-to-end ecosystem for brand visibility.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="about-process-section">
        <div class="about-process-container">
            <div class="process-header">
                <div>
                    <span class="process-label"><?php esc_html_e( 'How we work', 'efficient-modern' ); ?></span>
                    <h2 class="process-title">
                        From <span class="serif-text">Concept</span> to Installation
                    </h2>
                </div>
                <div class="process-navigation">
                    <button class="process-nav-btn prev" aria-label="<?php esc_attr_e( 'Previous', 'efficient-modern' ); ?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="process-nav-btn next" aria-label="<?php esc_attr_e( 'Next', 'efficient-modern' ); ?>">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="process-slider-wrapper">
                <div class="process-slider">
                    <!-- Step 1 -->
                    <div class="process-card">
                        <div class="process-card-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/process-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Discovery & Concept', 'efficient-modern' ); ?>">
                            <div class="process-card-number">01</div>
                        </div>
                        <h4 class="process-card-title"><?php esc_html_e( 'Discovery & Concept', 'efficient-modern' ); ?></h4>
                        <p class="process-card-description">
                            <?php esc_html_e( 'We begin by understanding your brand\'s DNA, objectives, and the spatial environment of the project.', 'efficient-modern' ); ?>
                        </p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="process-card">
                        <div class="process-card-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/process-2.jpg' ); ?>" alt="<?php esc_attr_e( 'Design Excellence', 'efficient-modern' ); ?>">
                            <div class="process-card-number">02</div>
                        </div>
                        <h4 class="process-card-title"><?php esc_html_e( 'Design Excellence', 'efficient-modern' ); ?></h4>
                        <p class="process-card-description">
                            <?php esc_html_e( 'Our design team creates high-fidelity mockups that translate your vision into technical print specifications.', 'efficient-modern' ); ?>
                        </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="process-card">
                        <div class="process-card-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/process-3.jpg' ); ?>" alt="<?php esc_attr_e( 'Precision Printing', 'efficient-modern' ); ?>">
                            <div class="process-card-number">03</div>
                        </div>
                        <h4 class="process-card-title"><?php esc_html_e( 'Precision Printing', 'efficient-modern' ); ?></h4>
                        <p class="process-card-description">
                            <?php esc_html_e( 'Using state-of-the-art machinery, we execute the print with surgical precision on premium materials.', 'efficient-modern' ); ?>
                        </p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="process-card">
                        <div class="process-card-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/process-4.jpg' ); ?>" alt="<?php esc_attr_e( 'Seamless Installation', 'efficient-modern' ); ?>">
                            <div class="process-card-number">04</div>
                        </div>
                        <h4 class="process-card-title"><?php esc_html_e( 'Seamless Installation', 'efficient-modern' ); ?></h4>
                        <p class="process-card-description">
                            <?php esc_html_e( 'Our expert team handles the logistics and installation, ensuring a flawless final presentation.', 'efficient-modern' ); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="about-team-section">
        <div class="container">
            <div class="team-section-header">
                <span class="team-label"><?php esc_html_e( 'The Visionaries', 'efficient-modern' ); ?></span>
                <h2 class="team-title">Led by <span class="serif-text">Expertise</span></h2>
            </div>
            
            <div class="team-grid">
                <?php if ( function_exists( 'have_rows' ) && have_rows( 'team_members' ) ) : ?>
                    <?php while ( have_rows( 'team_members' ) ) : the_row(); ?>
                        <div class="team-member">
                            <div class="team-member-image">
                                <?php 
                                $member_image = get_sub_field( 'member_image' );
                                if ( $member_image ) :
                                ?>
                                    <img src="<?php echo esc_url( $member_image ); ?>" alt="<?php echo esc_attr( get_sub_field( 'member_name' ) ); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="team-member-info">
                                <h5 class="team-member-name"><?php the_sub_field( 'member_name' ); ?></h5>
                                <p class="team-member-role"><?php the_sub_field( 'member_role' ); ?></p>
                                <p class="team-member-bio"><?php the_sub_field( 'member_bio' ); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <!-- Default Team Members -->
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-1.jpg' ); ?>" alt="CEO">
                        </div>
                        <div class="team-member-info">
                            <h5 class="team-member-name"><?php esc_html_e( 'Ahmed Al-Maktoum', 'efficient-modern' ); ?></h5>
                            <p class="team-member-role"><?php esc_html_e( 'Founder & CEO', 'efficient-modern' ); ?></p>
                            <p class="team-member-bio"><?php esc_html_e( '20 years of experience in regional advertising and large-format digital production.', 'efficient-modern' ); ?></p>
                        </div>
                    </div>
                    
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-2.jpg' ); ?>" alt="Creative Director">
                        </div>
                        <div class="team-member-info">
                            <h5 class="team-member-name"><?php esc_html_e( 'Sarah Jenkins', 'efficient-modern' ); ?></h5>
                            <p class="team-member-role"><?php esc_html_e( 'Creative Director', 'efficient-modern' ); ?></p>
                            <p class="team-member-bio"><?php esc_html_e( 'Award-winning designer focusing on high-end retail branding and environmental design.', 'efficient-modern' ); ?></p>
                        </div>
                    </div>
                    
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-3.jpg' ); ?>" alt="Operations Manager">
                        </div>
                        <div class="team-member-info">
                            <h5 class="team-member-name"><?php esc_html_e( 'Marcus Chen', 'efficient-modern' ); ?></h5>
                            <p class="team-member-role"><?php esc_html_e( 'Head of Operations', 'efficient-modern' ); ?></p>
                            <p class="team-member-bio"><?php esc_html_e( 'Logistics expert ensuring every project is delivered on time across the Middle East.', 'efficient-modern' ); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="about-cta-section">
        <div class="about-cta-background">
            <span class="about-cta-watermark"><?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ) ); ?></span>
        </div>
        <div class="about-cta-content">
            <h2 class="about-cta-title">
                Ready to bring your <span class="serif-text">vision</span> to life?
            </h2>
            <div class="about-cta-buttons">
                <button type="button" class="btn-cta-primary" data-toggle="modal" data-target="#requestQuoteModal">
                    <?php esc_html_e( 'Start a Project', 'efficient-modern' ); ?>
                </button>
                <a href="<?php echo esc_url( home_url( '/products' ) ); ?>" class="btn-cta-secondary">
                    <?php esc_html_e( 'View Portfolio', 'efficient-modern' ); ?>
                </a>
            </div>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<style>
/* About Us Page Styles */

/* Hero Section */
.about-hero-section {
    min-height: 100vh;
    padding-top: 100px;
}

.about-hero-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: calc(100vh - 100px);
}

.about-hero-content {
    display: flex;
    align-items: center;
    padding: 4rem 6rem;
    background: var(--color-bg-white);
}

.about-hero-inner {
    max-width: 600px;
}

.about-hero-label {
    display: block;
    color: var(--color-primary);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 2rem;
}

.about-hero-title {
    font-size: 3.5rem;
    font-weight: 300;
    line-height: 1.2;
    margin-bottom: 2rem;
}

.serif-text {
    font-family: 'Times New Roman', serif;
    font-style: italic;
    font-weight: 400;
}

.about-hero-description {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--color-text-light);
    margin-bottom: 3rem;
}

.about-hero-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.divider-line {
    width: 48px;
    height: 1px;
    background: var(--color-primary);
}

.divider-text {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.about-hero-image {
    position: relative;
    overflow: hidden;
}

.about-hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(100%);
    transition: filter 0.7s ease;
}

.about-hero-image:hover img {
    filter: grayscale(0%);
}

.about-hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(139, 21, 56, 0.1);
    mix-blend-mode: multiply;
}

/* Stats Section */
.about-stats-section {
    padding: 6rem 0;
    border-top: 1px solid rgba(139, 21, 56, 0.1);
    border-bottom: 1px solid rgba(139, 21, 56, 0.1);
}

.about-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 4rem;
    font-weight: 800;
    color: var(--color-primary);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    font-weight: 700;
    color: var(--color-text-light);
}

/* Philosophy Section */
.about-philosophy-section {
    padding: 8rem 0;
    background: var(--color-bg-white);
}

.about-philosophy-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.about-philosophy-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 4rem;
    align-items: start;
}

.philosophy-title {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.4;
}

.philosophy-highlight {
    color: var(--color-primary);
}

.philosophy-content {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--color-text-light);
}

.philosophy-content p {
    margin-bottom: 1.5rem;
}

/* Process Section */
.about-process-section {
    padding: 8rem 0;
    background: var(--color-bg-light);
    overflow: hidden;
}

.about-process-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.process-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 3rem;
}

.process-label {
    display: block;
    color: var(--color-primary);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 1rem;
}

.process-title {
    font-size: 3rem;
    font-weight: 300;
}

.process-navigation {
    display: flex;
    gap: 1rem;
}

.process-nav-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 1px solid rgba(139, 21, 56, 0.2);
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.process-nav-btn:hover {
    background: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
}

.process-slider-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: var(--color-primary) #f1f1f1;
}

.process-slider {
    display: flex;
    gap: 2rem;
    padding-bottom: 2rem;
}

.process-card {
    min-width: 350px;
    flex-shrink: 0;
}

.process-card-image {
    position: relative;
    height: 280px;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 2rem;
}

.process-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(100%);
    transition: all 0.5s ease;
}

.process-card:hover .process-card-image img {
    filter: grayscale(0%);
    transform: scale(1.05);
}

.process-card-number {
    position: absolute;
    top: 1rem;
    left: 1rem;
    width: 48px;
    height: 48px;
    background: var(--color-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    border-radius: 8px;
}

.process-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.process-card-description {
    color: var(--color-text-light);
    line-height: 1.6;
}

/* Team Section */
.about-team-section {
    padding: 8rem 0;
}

.team-section-header {
    text-align: center;
    margin-bottom: 5rem;
}

.team-label {
    display: block;
    color: var(--color-primary);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 1rem;
}

.team-title {
    font-size: 2.5rem;
    font-weight: 300;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 3rem;
}

.team-member {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.team-member-image {
    aspect-ratio: 4/5;
    border-radius: 12px;
    overflow: hidden;
    background: #e5e7eb;
}

.team-member-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(100%);
    transition: filter 0.7s ease;
}

.team-member:hover .team-member-image img {
    filter: grayscale(0%);
}

.team-member-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.team-member-role {
    color: var(--color-primary);
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1rem;
}

.team-member-bio {
    color: var(--color-text-light);
    font-size: 0.875rem;
    line-height: 1.6;
}

/* CTA Section */
.about-cta-section {
    position: relative;
    padding: 6rem 0;
    background: var(--color-primary);
    color: white;
    overflow: hidden;
}

.about-cta-background {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.1;
    pointer-events: none;
}

.about-cta-watermark {
    font-size: 20rem;
    font-weight: 900;
    text-transform: uppercase;
    user-select: none;
}

.about-cta-content {
    position: relative;
    z-index: 10;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.about-cta-title {
    font-size: 3.5rem;
    font-weight: 200;
    line-height: 1.3;
    margin-bottom: 3rem;
}

.about-cta-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
}

.btn-cta-primary,
.btn-cta-secondary {
    padding: 1.25rem 2.5rem;
    border-radius: 9999px;
    font-weight: 700;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    text-decoration: none;
    display: inline-block;
}

.btn-cta-primary {
    background: white;
    color: var(--color-primary);
}

.btn-cta-primary:hover {
    transform: scale(1.05);
}

.btn-cta-secondary {
    background: transparent;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.btn-cta-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Responsive Design */
@media (max-width: 992px) {
    .about-hero-grid {
        grid-template-columns: 1fr;
    }
    
    .about-hero-content {
        padding: 3rem 2rem;
    }
    
    .about-hero-title {
        font-size: 2.5rem;
    }
    
    .about-stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    
    .about-philosophy-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .process-title,
    .about-cta-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .process-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 2rem;
    }
    
    .about-cta-watermark {
        font-size: 8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Process slider navigation
    const slider = document.querySelector('.process-slider');
    const prevBtn = document.querySelector('.process-nav-btn.prev');
    const nextBtn = document.querySelector('.process-nav-btn.next');
    
    if (slider && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function() {
            slider.scrollBy({ left: -400, behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', function() {
            slider.scrollBy({ left: 400, behavior: 'smooth' });
        });
    }
});
</script>

<?php
get_footer();
