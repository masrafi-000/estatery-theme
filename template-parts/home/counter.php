<?php
$stats = [
    ["count" => "800", "suffix" => "+", "label" => t('home.stats.listed')],
    ["count" => "1200", "suffix" => "+", "label" => t('home.stats.families')],
    ["count" => "15", "suffix" => "K", "label" => t('home.stats.visitors')],
    ["count" => "97", "suffix" => "%", "label" => t('home.stats.satisfaction')]
];
?>


<section class="py-20 bg-primary" id="stats-counter-section">
    <div class="container mx-auto px-6 js-reveal-stagger">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
            <?php foreach ($stats as $stat): ?>
                <div class="stat-item js-reveal-fade">
                    <h3 class="text-4xl lg:text-5xl font-bold mb-2 flex items-center justify-center">
                        <span class="counter-value" data-target="<?php echo $stat['count']; ?>">0</span>
                        <span><?php echo $stat['suffix']; ?></span>
                    </h3>
                    <p class="text-blue-100 text-lg font-medium"><?php echo $stat['label']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<style>
    .bg-primary {
        background-color: #3b82f6;
    }

    .text-blue-100 {
        color: #dbeafe;
    }

    .stat-item {
        transition: transform 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
    }
</style>