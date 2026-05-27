<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f172a">
        <title>MonProjet Resto</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root {
                color-scheme: dark;
                --bg: #08111f;
                --panel: rgba(8, 17, 31, 0.72);
                --panel-strong: rgba(15, 23, 42, 0.9);
                --line: rgba(255, 255, 255, 0.12);
                --text: #f8fafc;
                --muted: #cbd5e1;
                --accent: #f59e0b;
                --accent-2: #22c55e;
                --accent-3: #38bdf8;
                --shadow: 0 24px 80px rgba(0, 0, 0, 0.35);
            }

            * { box-sizing: border-box; }
            html { scroll-behavior: smooth; }
            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(245, 158, 11, 0.20), transparent 26%),
                    radial-gradient(circle at 80% 20%, rgba(56, 189, 248, 0.16), transparent 22%),
                    radial-gradient(circle at bottom right, rgba(34, 197, 94, 0.14), transparent 24%),
                    linear-gradient(135deg, #030712 0%, #08111f 45%, #0f172a 100%);
            }

            .shell {
                position: relative;
                overflow: hidden;
                min-height: 100vh;
            }

            .grid-noise {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
                background-size: 44px 44px;
                mask-image: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent 88%);
                pointer-events: none;
            }

            .wrap {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
                position: relative;
                z-index: 1;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 24px 0;
                gap: 16px;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                font-weight: 700;
                letter-spacing: 0.04em;
            }

            .mark {
                width: 42px;
                height: 42px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, rgba(245, 158, 11, 0.95), rgba(34, 197, 94, 0.92));
                box-shadow: 0 16px 36px rgba(245, 158, 11, 0.25);
                color: #08111f;
                font-weight: 900;
            }

            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 44px;
                padding: 0 18px;
                border-radius: 999px;
                border: 1px solid var(--line);
                color: var(--text);
                text-decoration: none;
                background: rgba(255, 255, 255, 0.04);
                backdrop-filter: blur(12px);
            }

            .btn.primary {
                background: linear-gradient(135deg, var(--accent), #fb7185);
                color: #08111f;
                border-color: transparent;
                font-weight: 700;
            }

            .hero {
                display: grid;
                grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
                gap: 28px;
                align-items: stretch;
                padding: 20px 0 48px;
            }

            .panel {
                background: var(--panel);
                border: 1px solid var(--line);
                border-radius: 28px;
                box-shadow: var(--shadow);
                backdrop-filter: blur(22px);
            }

            .hero-copy {
                padding: 34px;
            }

            .eyebrow {
                display: inline-flex;
                gap: 10px;
                align-items: center;
                padding: 8px 14px;
                border-radius: 999px;
                border: 1px solid rgba(255,255,255,0.10);
                background: rgba(255,255,255,0.05);
                color: var(--muted);
                font-size: 0.92rem;
            }

            .eyebrow-dot {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: var(--accent-2);
                box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.16);
            }

            h1 {
                margin: 20px 0 14px;
                font-size: clamp(2.8rem, 6vw, 5.4rem);
                line-height: 0.95;
                letter-spacing: -0.05em;
            }

            .lead {
                margin: 0;
                max-width: 62ch;
                color: var(--muted);
                font-size: 1.06rem;
                line-height: 1.75;
            }

            .metrics {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 14px;
                margin-top: 26px;
            }

            .metric {
                padding: 16px;
                border-radius: 20px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .metric strong {
                display: block;
                font-size: 1.35rem;
                margin-bottom: 4px;
            }

            .metric span {
                color: var(--muted);
                font-size: 0.95rem;
            }

            .preview {
                padding: 20px;
                display: grid;
                gap: 16px;
            }

            .preview-card {
                padding: 18px;
                border-radius: 22px;
                background: var(--panel-strong);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .preview-title {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                margin-bottom: 14px;
            }

            .badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border-radius: 999px;
                background: rgba(56, 189, 248, 0.12);
                color: #d7f3ff;
                border: 1px solid rgba(56, 189, 248, 0.2);
                font-size: 0.88rem;
            }

            .badge .dot {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: #38bdf8;
            }

            .stack {
                display: grid;
                gap: 12px;
            }

            .stack-item {
                display: flex;
                gap: 12px;
                align-items: flex-start;
                padding: 14px;
                border-radius: 18px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .stack-icon {
                width: 38px;
                height: 38px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                flex: none;
                background: rgba(245, 158, 11, 0.16);
                color: #fde68a;
            }

            .section {
                padding: 0 0 42px;
            }

            .section h2 {
                font-size: clamp(1.6rem, 2vw, 2.2rem);
                margin: 0 0 14px;
                letter-spacing: -0.03em;
            }

            .section p {
                margin: 0;
                color: var(--muted);
                line-height: 1.75;
            }

            .pillars {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 18px;
                margin-top: 18px;
            }

            .pillar {
                padding: 22px;
                border-radius: 24px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .pillar .num {
                display: inline-flex;
                width: 36px;
                height: 36px;
                border-radius: 12px;
                align-items: center;
                justify-content: center;
                font-weight: 800;
                background: rgba(34, 197, 94, 0.16);
                color: #bbf7d0;
                margin-bottom: 12px;
            }

            .timeline {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 14px;
                margin-top: 18px;
            }

            .step {
                padding: 18px;
                border-radius: 20px;
                background: rgba(255,255,255,0.035);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .step time {
                display: inline-block;
                margin-bottom: 10px;
                color: #fde68a;
                font-weight: 700;
            }

            .footer-note {
                padding: 12px 0 44px;
                color: var(--muted);
                text-align: center;
                font-size: 0.95rem;
            }

            @media (max-width: 980px) {
                .hero,
                .pillars,
                .timeline,
                .metrics {
                    grid-template-columns: 1fr;
                }

                .topbar {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .hero-copy {
                    padding: 24px;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <div class="grid-noise"></div>

            <div class="wrap">
                <header class="topbar">
                    <div class="brand">
                        <div class="mark">MR</div>
                        <div>
                            MonProjet Resto
                            <div style="color: var(--muted); font-size: 0.92rem; font-weight: 500;">Cantine connectée sur abonnement</div>
                        </div>
                    </div>

                    <nav class="actions" aria-label="Navigation principale">
                        <a class="btn" href="#piliers">Piliers</a>
                        <a class="btn" href="#journee">Journée</a>
                        <a class="btn primary" href="#demarrer">Démarrer le projet</a>
                    </nav>
                </header>

                <main>
                    <section class="hero">
                        <div class="panel hero-copy">
                            <div class="eyebrow"><span class="eyebrow-dot"></span> Zéro gaspillage, gain de temps, multi-restaurant</div>
                            <h1>La cantine du quartier, pilotée comme un vrai produit SaaS.</h1>
                            <p class="lead">
                                Une application pensée pour les micro-restaurants qui vendent des abonnements, publient le plat du jour, bloquent les commandes à heure fixe et calculent les quantités exactes à cuisiner.
                            </p>

                            <div class="actions" style="margin-top: 26px;" id="demarrer">
                                <a class="btn primary" href="#piliers">Voir l’architecture</a>
                                <a class="btn" href="#journee">Comprendre la journée type</a>
                            </div>

                            <div class="metrics">
                                <div class="metric">
                                    <strong>1 code</strong>
                                    <span>par restaurant pour rejoindre l’espace.</span>
                                </div>
                                <div class="metric">
                                    <strong>10h30</strong>
                                    <span>heure limite pour figer les commandes.</span>
                                </div>
                                <div class="metric">
                                    <strong>100%</strong>
                                    <span>des abonnements suivis automatiquement.</span>
                                </div>
                            </div>
                        </div>

                        <aside class="panel preview">
                            <div class="preview-card">
                                <div class="preview-title">
                                    <strong>Tableau du jour</strong>
                                    <span class="badge"><span class="dot"></span> Commandes ouvertes</span>
                                </div>

                                <div class="stack">
                                    <div class="stack-item">
                                        <div class="stack-icon">1</div>
                                        <div>
                                            <strong>Plat du jour</strong>
                                            <div style="color: var(--muted); margin-top: 4px;">Thiéboudienne publiée à 08h00, visible uniquement aux abonnés actifs.</div>
                                        </div>
                                    </div>
                                    <div class="stack-item">
                                        <div class="stack-icon">2</div>
                                        <div>
                                            <strong>Prédiction cuisine</strong>
                                            <div style="color: var(--muted); margin-top: 4px;">L’application calcule le nombre de portions et réduit le risque de surplus.</div>
                                        </div>
                                    </div>
                                    <div class="stack-item">
                                        <div class="stack-icon">3</div>
                                        <div>
                                            <strong>Livraison</strong>
                                            <div style="color: var(--muted); margin-top: 4px;">Validation finale du bol servi, avec historique propre côté restaurant.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="preview-card">
                                <div class="preview-title">
                                    <strong>Code restaurant</strong>
                                    <span class="badge"><span class="dot"></span> Multi-restaurant</span>
                                </div>

                                <div style="font-size: 1.8rem; letter-spacing: 0.22em; font-weight: 800;">MRS-8K4P</div>
                                <div style="color: var(--muted); margin-top: 8px; line-height: 1.7;">Un code unique permet au client de rejoindre instantanément la cantine du restaurant choisi.</div>
                            </div>
                        </aside>
                    </section>

                    <section class="section" id="piliers">
                        <h2>Les trois piliers du produit</h2>
                        <p>Chaque bloc est pensé pour résoudre un problème concret sur le terrain, sans surcharge fonctionnelle inutile.</p>

                        <div class="pillars">
                            <article class="pillar">
                                <div class="num">01</div>
                                <h3>Abonnement clair</h3>
                                <p>Date de début, date de fin, statut actif ou expiré, et blocage automatique quand l’abonnement est terminé.</p>
                            </article>
                            <article class="pillar">
                                <div class="num">02</div>
                                <h3>Plat du jour intelligent</h3>
                                <p>Le restaurant publie le menu, les clients réservent avant l’heure limite, et la cuisine voit la demande exacte.</p>
                            </article>
                            <article class="pillar">
                                <div class="num">03</div>
                                <h3>Multi-restaurant</h3>
                                <p>Chaque restaurant a son espace, son code unique et sa propre base de clients pour pouvoir vendre le produit à grande échelle.</p>
                            </article>
                        </div>
                    </section>

                    <section class="section" id="journee">
                        <h2>Une journée type</h2>
                        <p>Le workflow reste simple pour le restaurateur comme pour le client, afin que l’application soit réellement adoptée.</p>

                        <div class="timeline">
                            <div class="step">
                                <time>08h00</time>
                                <div>Le restaurant publie le menu du jour depuis son téléphone.</div>
                            </div>
                            <div class="step">
                                <time>09h00</time>
                                <div>Le client abonné voit le plat et confirme qu’il mange aujourd’hui.</div>
                            </div>
                            <div class="step">
                                <time>10h30</time>
                                <div>Les commandes se ferment automatiquement pour stabiliser la préparation.</div>
                            </div>
                            <div class="step">
                                <time>13h00</time>
                                <div>Le plat est servi, puis marqué comme livré pour garder un suivi propre.</div>
                            </div>
                        </div>
                    </section>
                </main>

                <div class="footer-note">
                    Conçu pour passer d’une petite cantine de quartier à une solution vendable à plusieurs restaurants.
                </div>
            </div>
        </div>
    </body>
</html>