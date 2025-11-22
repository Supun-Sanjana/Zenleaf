<?php
session_start();
require_once './src/templates/shared/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonsai Care Guide - Complete Guide to Bonsai Plant Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .care-card {
            transition: all 0.3s ease;
        }
        .care-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .step-number {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .section-divider {
            background: linear-gradient(90deg, transparent, #10b981, transparent);
            height: 2px;
        }
        .tip-highlight {
            background: linear-gradient(135deg, #fef3c7, #fcd34d);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-emerald-600 to-green-700 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🌳 Bonsai Care Guide</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Master the ancient art of bonsai cultivation</p>
            <div class="flex justify-center space-x-4">
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">🌱 Beginner Friendly</span>
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">📚 Complete Guide</span>
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">🎯 Expert Tips</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <!-- Quick Navigation -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Navigation</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#basics" class="text-emerald-600 hover:text-emerald-800 font-medium">🌿 Basics</a>
                <a href="#watering" class="text-emerald-600 hover:text-emerald-800 font-medium">💧 Watering</a>
                <a href="#pruning" class="text-emerald-600 hover:text-emerald-800 font-medium">✂️ Pruning</a>
                <a href="#repotting" class="text-emerald-600 hover:text-emerald-800 font-medium">🪴 Repotting</a>
                <a href="#fertilizing" class="text-emerald-600 hover:text-emerald-800 font-medium">🌱 Fertilizing</a>
                <a href="#styling" class="text-emerald-600 hover:text-emerald-800 font-medium">🎨 Styling</a>
                <a href="#problems" class="text-emerald-600 hover:text-emerald-800 font-medium">⚠️ Problems</a>
                <a href="#seasonal" class="text-emerald-600 hover:text-emerald-800 font-medium">📅 Seasonal</a>
            </div>
        </div>

        <!-- Bonsai Basics Section -->
        <section id="basics" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">🌿 Bonsai Basics</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="step-number w-8 h-8 rounded-full text-white flex items-center justify-center text-sm font-bold mr-3">1</div>
                        <h3 class="text-xl font-semibold">What is Bonsai?</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Bonsai is the Japanese art of growing miniature trees in containers. The word "bonsai" means "planted in a container" and represents harmony between nature, humanity, and art.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Originated in China over 1000 years ago</li>
                        <li>• Refined in Japan into the art we know today</li>
                        <li>• Requires patience, skill, and dedication</li>
                        <li>• Creates living sculptures that change with time</li>
                    </ul>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="step-number w-8 h-8 rounded-full text-white flex items-center justify-center text-sm font-bold mr-3">2</div>
                        <h3 class="text-xl font-semibold">Choosing Your First Bonsai</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Select a beginner-friendly species that matches your environment and experience level.</p>
                    <div class="space-y-3">
                        <div class="bg-green-50 p-3 rounded">
                            <strong class="text-green-800">Indoor Bonsai:</strong>
                            <span class="text-green-700">Ficus, Jade, Chinese Elm</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded">
                            <strong class="text-blue-800">Outdoor Bonsai:</strong>
                            <span class="text-blue-700">Juniper, Pine, Maple</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Watering Section -->
        <section id="watering" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">💧 Watering Your Bonsai</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">💧</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">When to Water</h3>
                        <p class="text-gray-600 text-sm">Check soil daily. Water when the top inch feels slightly dry but not completely dried out.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">🚿</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">How to Water</h3>
                        <p class="text-gray-600 text-sm">Water thoroughly until it drains from the bottom. Use a watering can with a fine nozzle.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">⚖️</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Water Quality</h3>
                        <p class="text-gray-600 text-sm">Use rainwater or filtered water. Avoid hard tap water with high mineral content.</p>
                    </div>
                </div>
            </div>

            <div class="tip-highlight rounded-lg p-6 mb-8">
                <h4 class="font-semibold text-amber-800 mb-2">💡 Pro Tip: The Finger Test</h4>
                <p class="text-amber-700">Insert your finger 1 inch into the soil. If it's dry, it's time to water. If it's moist, wait another day.</p>
            </div>
        </section>

        <!-- Pruning Section -->
        <section id="pruning" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">✂️ Pruning & Shaping</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="text-2xl mr-2">🌿</span>
                        Maintenance Pruning
                    </h3>
                    <p class="text-gray-600 mb-4">Regular pruning to maintain shape and health.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>• Remove dead, diseased, or damaged branches</li>
                        <li>• Cut back overgrown shoots</li>
                        <li>• Thin out dense areas for light penetration</li>
                        <li>• Prune during growing season</li>
                    </ul>
                    <div class="mt-4 p-3 bg-green-50 rounded">
                        <strong class="text-green-800">Best Time:</strong>
                        <span class="text-green-700">Spring and early summer</span>
                    </div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="text-2xl mr-2">🎨</span>
                        Structural Pruning
                    </h3>
                    <p class="text-gray-600 mb-4">Major pruning to create and refine the bonsai's structure.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>• Remove large branches to create taper</li>
                        <li>• Establish primary, secondary branches</li>
                        <li>• Create movement and character</li>
                        <li>• Use proper bonsai tools</li>
                    </ul>
                    <div class="mt-4 p-3 bg-blue-50 rounded">
                        <strong class="text-blue-800">Best Time:</strong>
                        <span class="text-blue-700">Late winter/early spring</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-6 mt-8">
                <h4 class="font-semibold text-red-800 mb-2">⚠️ Pruning Safety Tips</h4>
                <ul class="text-red-700 space-y-1 text-sm">
                    <li>• Never remove more than 1/3 of foliage at once</li>
                    <li>• Use clean, sharp tools to prevent infection</li>
                    <li>• Seal large cuts with wound paste</li>
                    <li>• Allow recovery time between major pruning sessions</li>
                </ul>
            </div>
        </section>

        <!-- Repotting Section -->
        <section id="repotting" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">🪴 Repotting Your Bonsai</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="text-center">
                        <div class="step-number w-12 h-12 rounded-full text-white flex items-center justify-center mx-auto mb-3 text-lg font-bold">1</div>
                        <h4 class="font-semibold mb-2">Check Roots</h4>
                        <p class="text-sm text-gray-600">Look for roots circling the pot or growing through drainage holes</p>
                    </div>
                    <div class="text-center">
                        <div class="step-number w-12 h-12 rounded-full text-white flex items-center justify-center mx-auto mb-3 text-lg font-bold">2</div>
                        <h4 class="font-semibold mb-2">Remove Tree</h4>
                        <p class="text-sm text-gray-600">Carefully remove the tree and examine the root system</p>
                    </div>
                    <div class="text-center">
                        <div class="step-number w-12 h-12 rounded-full text-white flex items-center justify-center mx-auto mb-3 text-lg font-bold">3</div>
                        <h4 class="font-semibold mb-2">Trim Roots</h4>
                        <p class="text-sm text-gray-600">Prune up to 1/3 of the root mass, focusing on thick roots</p>
                    </div>
                    <div class="text-center">
                        <div class="step-number w-12 h-12 rounded-full text-white flex items-center justify-center mx-auto mb-3 text-lg font-bold">4</div>
                        <h4 class="font-semibold mb-2">Replant</h4>
                        <p class="text-sm text-gray-600">Place in fresh soil mix and secure with wire if needed</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold mb-3">Repotting Schedule</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• <strong>Young trees:</strong> Every 1-2 years</li>
                            <li>• <strong>Mature trees:</strong> Every 3-5 years</li>
                            <li>• <strong>Old trees:</strong> Every 5-10 years</li>
                            <li>• <strong>Best time:</strong> Early spring before growth starts</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-3">Soil Mix Recipe</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• <strong>Akadama:</strong> 40% (clay granules)</li>
                            <li>• <strong>Pumice:</strong> 30% (drainage)</li>
                            <li>• <strong>Lava rock:</strong> 30% (aeration)</li>
                            <li>• <strong>Alternative:</strong> Commercial bonsai soil</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fertilizing Section -->
        <section id="fertilizing" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">🌱 Fertilizing Your Bonsai</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-3 text-green-700">🌸 Spring</h3>
                    <p class="text-sm text-gray-600 mb-3">High nitrogen for new growth</p>
                    <div class="bg-green-50 p-3 rounded text-sm">
                        <strong>NPK Ratio:</strong> 10-6-6<br>
                        <strong>Frequency:</strong> Every 2 weeks
                    </div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-3 text-yellow-700">☀️ Summer</h3>
                    <p class="text-sm text-gray-600 mb-3">Balanced nutrition for health</p>
                    <div class="bg-yellow-50 p-3 rounded text-sm">
                        <strong>NPK Ratio:</strong> 6-6-6<br>
                        <strong>Frequency:</strong> Every 2-3 weeks
                    </div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-3 text-orange-700">🍂 Fall</h3>
                    <p class="text-sm text-gray-600 mb-3">Low nitrogen, high potassium</p>
                    <div class="bg-orange-50 p-3 rounded text-sm">
                        <strong>NPK Ratio:</strong> 3-9-9<br>
                        <strong>Frequency:</strong> Monthly
                    </div>
                </div>
            </div>

            <div class="tip-highlight rounded-lg p-6 mt-8">
                <h4 class="font-semibold text-amber-800 mb-2">💡 Fertilizer Tips</h4>
                <ul class="text-amber-700 space-y-1 text-sm">
                    <li>• Use liquid fertilizer diluted to half strength</li>
                    <li>• Organic fertilizers release nutrients slowly</li>
                    <li>• Don't fertilize dry soil - water first</li>
                    <li>• Stop fertilizing in winter (dormant period)</li>
                </ul>
            </div>
        </section>

        <!-- Styling Section -->
        <section id="styling" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">🎨 Bonsai Styling</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🌲 Formal Upright</h3>
                    <p class="text-sm text-gray-600 mb-3">Straight trunk, symmetrical branches</p>
                    <div class="text-xs text-gray-500">Best for: Pine, Spruce, Juniper</div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🌊 Informal Upright</h3>
                    <p class="text-sm text-gray-600 mb-3">Curved trunk, natural appearance</p>
                    <div class="text-xs text-gray-500">Best for: Most deciduous trees</div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🏔️ Windswept</h3>
                    <p class="text-sm text-gray-600 mb-3">Branches swept to one side</p>
                    <div class="text-xs text-gray-500">Best for: Juniper, Pine</div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🪨 Cascade</h3>
                    <p class="text-sm text-gray-600 mb-3">Trunk flows downward like waterfall</p>
                    <div class="text-xs text-gray-500">Best for: Juniper, Willow</div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🌳 Group Planting</h3>
                    <p class="text-sm text-gray-600 mb-3">Multiple trees creating forest</p>
                    <div class="text-xs text-gray-500">Best for: Same species trees</div>
                </div>

                <div class="care-card bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-semibold mb-3">🪨 Root Over Rock</h3>
                    <p class="text-sm text-gray-600 mb-3">Roots growing over stone</p>
                    <div class="text-xs text-gray-500">Best for: Ficus, Trident Maple</div>
                </div>
            </div>
        </section>

        <!-- Common Problems Section -->
        <section id="problems" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">⚠️ Common Problems & Solutions</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-red-100 p-2 rounded-full">
                            <span class="text-red-600 text-xl">🍂</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-red-800 mb-2">Yellowing/Dropping Leaves</h3>
                            <p class="text-gray-600 mb-3">Usually caused by overwatering, underwatering, or stress.</p>
                            <div class="bg-red-50 p-3 rounded">
                                <strong class="text-red-800">Solutions:</strong>
                                <span class="text-red-700">Check soil moisture, adjust watering schedule, ensure proper drainage</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-yellow-100 p-2 rounded-full">
                            <span class="text-yellow-600 text-xl">🐛</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-yellow-800 mb-2">Pest Infestation</h3>
                            <p class="text-gray-600 mb-3">Common pests include aphids, spider mites, and scale insects.</p>
                            <div class="bg-yellow-50 p-3 rounded">
                                <strong class="text-yellow-800">Solutions:</strong>
                                <span class="text-yellow-700">Use insecticidal soap, neem oil, or systemic insecticides</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <span class="text-blue-600 text-xl">💧</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-blue-800 mb-2">Root Rot</h3>
                            <p class="text-gray-600 mb-3">Caused by overwatering and poor drainage.</p>
                            <div class="bg-blue-50 p-3 rounded">
                                <strong class="text-blue-800">Solutions:</strong>
                                <span class="text-blue-700">Improve drainage, reduce watering, repot with fresh soil</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seasonal Care Section -->
        <section id="seasonal" class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">📅 Seasonal Care Calendar</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="care-card bg-gradient-to-br from-green-100 to-green-200 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">🌸 Spring</h3>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>• Repotting time</li>
                        <li>• Start fertilizing</li>
                        <li>• Begin training</li>
                        <li>• Increase watering</li>
                        <li>• Watch for new growth</li>
                    </ul>
                </div>

                <div class="care-card bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-3">☀️ Summer</h3>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <li>• Daily watering check</li>
                        <li>• Provide shade in heat</li>
                        <li>• Continue fertilizing</li>
                        <li>• Pinch new growth</li>
                        <li>• Watch for pests</li>
                    </ul>
                </div>

                <div class="care-card bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-orange-800 mb-3">🍂 Fall</h3>
                    <ul class="text-sm text-orange-700 space-y-1">
                        <li>• Reduce fertilizing</li>
                        <li>• Prepare for winter</li>
                        <li>• Enjoy fall colors</li>
                        <li>• Clean fallen leaves</li>
                        <li>• Reduce watering</li>
                    </ul>
                </div>

                <div class="care-card bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">❄️ Winter</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Protect from frost</li>
                        <li>• Minimal watering</li>
                        <li>• No fertilizing</li>
                        <li>• Plan next year</li>
                        <li>• Tool maintenance</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Tools & Equipment Section -->
        <section class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">🛠️ Essential Bonsai Tools</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">✂️</span>
                        </div>
                        <h4 class="font-semibold mb-2">Pruning Shears</h4>
                        <p class="text-sm text-gray-600">For cutting branches and shoots</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">🪝</span>
                        </div>
                        <h4 class="font-semibold mb-2">Wire Cutters</h4>
                        <p class="text-sm text-gray-600">For training and shaping branches</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">🔧</span>
                        </div>
                        <h4 class="font-semibold mb-2">Root Rake</h4>
                        <p class="text-sm text-gray-600">For untangling roots during repotting</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-emerald-600 to-green-700 text-white rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Ready to Start Your Bonsai Journey?</h2>
            <p class="text-lg mb-6 opacity-90">Browse our collection of bonsai trees and supplies</p>
            <div class="space-x-4">
                <a href="shop.php" class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Shop Bonsai Trees
                </a>
                <a href="shop.php" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-emerald-600 transition-colors">
                    View Supplies
                </a>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 bg-emerald-600 text-white p-3 rounded-full shadow-lg hover:bg-emerald-700 transition-colors hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Back to top button functionality
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Add fade-in animation to cards when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all care cards
        document.querySelectorAll('.care-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>