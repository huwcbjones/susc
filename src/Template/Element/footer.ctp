<footer>
    <?php if (!isset($sponsors) || $sponsors): ?>
        <div class="row">
            <div class="col-md-6 col-xs-12 text-center">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Funded by</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?= $this->Html->link('<h5>Southampton University Students\' Union</h5>' .
                            $this->Html->image('susu_logo.svg', ['alt' => 'Southampton University Students\' Union', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.susu.org',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $this->Html->link('<h5>Team Southampton</h5>' .
                            $this->Html->image('team_southampton.png', ['alt' => 'Team Southampton', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.susu.org/groups/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 text-center">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Proudly sponsored by</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <?= $this->Html->link('<h5>90 Degrees</h5>' .
                            $this->Html->image('90_degrees.png', ['alt' => '90 Degrees', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.ninetydegrees.com/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-sm-6 col-xs-12">
                        <?= $this->Html->link('<h5>Tariq Manzils</h5>' .
                            $this->Html->image('manzils.svg', ['alt' => 'Manzils', 'class' => 'img-responsive footer-logo center-block']),
                            'http://tariqmanzils.com/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-xs-12">
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p class="pull-left">&copy; <?= date("Y") ?> Southampton University Swimming Club.</p>
            <p class="pull-right">
                <?= $this->Html->link('Facebook', 'https://www.facebook.com/sotonswimteam/', ['target' => '_blank']) ?> &middot;
                <?= $this->Html->link('Facebook Group', 'https://www.facebook.com/groups/114314605328729/', ['target' => '_blank']) ?> &middot;
                <?= $this->Html->link('Instagram', 'https://www.instagram.com/swimsusc/', ['target' => '_blank']) ?> &middot;
                <?= $this->Html->link('Twitter', 'https://twitter.com/swimsusc', ['target' => '_blank']) ?>
            </p>
        </div>
    </div>
    <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Person",
  "name": "Southampton University Swimming Club",
  "url": "<?= $this->Url->build('/', ['fullBase' => true]) ?>",
  "sameAs": [
    "https://www.facebook.com/sotonswimteam/",
    "https://www.facebook.com/groups/114314605328729/",
    "https://www.instagram.com/swimsusc",
    "https://twitter.com/swimsusc"
  ]
}

    </script>
</footer>