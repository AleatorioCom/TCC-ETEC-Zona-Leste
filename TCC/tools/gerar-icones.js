/**
 * Gera os ícones e as telas de abertura do aplicativo Android.
 *
 * Uso: node tools/gerar-icones.js
 * Requer a dependência de desenvolvimento "sharp".
 *
 * O desenho é o mesmo do cabeçalho do app (folha estilizada), mantendo a
 * identidade visual verde do Sementes Digitais.
 */

const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const RAIZ = path.resolve(__dirname, '..');
const RES = path.join(RAIZ, 'android', 'app', 'src', 'main', 'res');

const VERDE_ESCURO = '#0f3d1c';
const VERDE = '#145324';
const VERDE_CLARO = '#2fa84f';

const folha = `
  <g fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 21C6.5 21 3.5 17.5 3.5 13c0-5.2 4.6-9.2 17-10-1 10.3-4.2 18-8.5 18Z"/>
    <path d="M3.5 21c3-7 8-11 14.5-13.5"/>
  </g>`;

function svgQuadrado(tamanho, arredondado) {
  const raio = arredondado ? tamanho / 2 : tamanho * 0.22;
  const escala = tamanho / 24;
  return `<svg xmlns="http://www.w3.org/2000/svg" width="${tamanho}" height="${tamanho}" viewBox="0 0 ${tamanho} ${tamanho}">
    <defs>
      <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0" stop-color="${VERDE_ESCURO}"/>
        <stop offset="1" stop-color="${VERDE_CLARO}"/>
      </linearGradient>
      <clipPath id="c"><rect width="${tamanho}" height="${tamanho}" rx="${raio}" ry="${raio}"/></clipPath>
    </defs>
    <g clip-path="url(#c)">
      <rect width="${tamanho}" height="${tamanho}" fill="url(#g)"/>
      <circle cx="${tamanho * 0.82}" cy="${tamanho * 0.16}" r="${tamanho * 0.32}" fill="#ffffff" opacity="0.07"/>
      <circle cx="${tamanho * 0.14}" cy="${tamanho * 0.88}" r="${tamanho * 0.26}" fill="#ffffff" opacity="0.06"/>
      <g transform="translate(${tamanho * 0.22} ${tamanho * 0.22}) scale(${escala * 0.56})">${folha}</g>
    </g>
  </svg>`;
}

function svgForeground(tamanho) {
  const escala = (tamanho / 24) * 0.62;
  const deslocamento = (tamanho - 24 * escala) / 2;
  return `<svg xmlns="http://www.w3.org/2000/svg" width="${tamanho}" height="${tamanho}" viewBox="0 0 ${tamanho} ${tamanho}">
    <g transform="translate(${deslocamento} ${deslocamento}) scale(${escala})">${folha}</g>
  </svg>`;
}

function svgSplash(largura, altura) {
  const menor = Math.min(largura, altura);
  const lado = menor * 0.3;
  const x = (largura - lado) / 2;
  const y = (altura - lado) / 2;
  const escala = (lado / 24) * 0.54;
  const deslocamento = (lado - 24 * escala) / 2;
  return `<svg xmlns="http://www.w3.org/2000/svg" width="${largura}" height="${altura}" viewBox="0 0 ${largura} ${altura}">
    <defs>
      <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0" stop-color="${VERDE_ESCURO}"/>
        <stop offset="1" stop-color="${VERDE}"/>
      </linearGradient>
      <linearGradient id="placa" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0" stop-color="${VERDE_CLARO}"/>
        <stop offset="1" stop-color="${VERDE}"/>
      </linearGradient>
    </defs>
    <rect width="${largura}" height="${altura}" fill="url(#bg)"/>
    <circle cx="${largura * 0.85}" cy="${altura * 0.12}" r="${menor * 0.22}" fill="#ffffff" opacity="0.05"/>
    <circle cx="${largura * 0.1}" cy="${altura * 0.9}" r="${menor * 0.3}" fill="#ffffff" opacity="0.04"/>
    <rect x="${x}" y="${y}" width="${lado}" height="${lado}" rx="${lado * 0.28}" fill="url(#placa)"/>
    <g transform="translate(${x + deslocamento} ${y + deslocamento}) scale(${escala})">${folha}</g>
  </svg>`;
}

const DENSIDADES = {
  mdpi: { icone: 48, foreground: 108 },
  hdpi: { icone: 72, foreground: 162 },
  xhdpi: { icone: 96, foreground: 216 },
  xxhdpi: { icone: 144, foreground: 324 },
  xxxhdpi: { icone: 192, foreground: 432 },
};

const SPLASHES = [
  ['drawable/splash.png', 480, 320],
  ['drawable-port-mdpi/splash.png', 320, 480],
  ['drawable-port-hdpi/splash.png', 480, 800],
  ['drawable-port-xhdpi/splash.png', 720, 1280],
  ['drawable-port-xxhdpi/splash.png', 960, 1600],
  ['drawable-port-xxxhdpi/splash.png', 1280, 1920],
  ['drawable-land-mdpi/splash.png', 480, 320],
  ['drawable-land-hdpi/splash.png', 800, 480],
  ['drawable-land-xhdpi/splash.png', 1280, 720],
  ['drawable-land-xxhdpi/splash.png', 1600, 960],
  ['drawable-land-xxxhdpi/splash.png', 1920, 1280],
];

async function principal() {
  if (!fs.existsSync(RES)) {
    throw new Error('Projeto Android não encontrado. Rode "npx cap add android" primeiro.');
  }

  for (const [densidade, medidas] of Object.entries(DENSIDADES)) {
    const pasta = path.join(RES, `mipmap-${densidade}`);
    fs.mkdirSync(pasta, { recursive: true });

    const { icone, foreground } = medidas;

    await sharp(Buffer.from(svgQuadrado(icone, false))).png().toFile(path.join(pasta, 'ic_launcher.png'));
    await sharp(Buffer.from(svgQuadrado(icone, true))).png().toFile(path.join(pasta, 'ic_launcher_round.png'));
    await sharp(Buffer.from(svgForeground(foreground))).png().toFile(path.join(pasta, 'ic_launcher_foreground.png'));
  }

  for (const [arquivo, largura, altura] of SPLASHES) {
    const destino = path.join(RES, arquivo);
    fs.mkdirSync(path.dirname(destino), { recursive: true });
    await sharp(Buffer.from(svgSplash(largura, altura))).png().toFile(destino);
  }

  // Ícone grande para reutilizar em lojas, documentação ou PWA.
  const pastaApp = path.join(RAIZ, 'app', 'img');
  fs.mkdirSync(pastaApp, { recursive: true });
  await sharp(Buffer.from(svgQuadrado(512, false))).png().toFile(path.join(pastaApp, 'icone-512.png'));

  // Cor de fundo do ícone adaptativo.
  const valores = path.join(RES, 'values');
  fs.mkdirSync(valores, { recursive: true });
  fs.writeFileSync(
    path.join(valores, 'ic_launcher_background.xml'),
    `<resources>\n    <color name="ic_launcher_background">${VERDE}</color>\n</resources>\n`,
    'utf8'
  );

  console.log('Ícones e splash screens gerados com sucesso.');
}

principal().catch((erro) => {
  console.error(erro);
  process.exit(1);
});
