const storageKeys = {
  presentations: 'teleprompt:presentations',
};

export function getPresentations() {
  return Object.values(
    JSON.parse(localStorage.getItem(storageKeys.presentations) || '{}')
  );
}

export function getPresentation(code) {
  const presentations = JSON.parse(
    localStorage.getItem(storageKeys.presentations) || '{}'
  );

  return presentations[code];
}

export function savePresentation(presentation) {
  const presentations = JSON.parse(
    localStorage.getItem(storageKeys.presentations) || '{}'
  );

  presentations[presentation.code] = presentation;

  localStorage.setItem(
    storageKeys.presentations,
    JSON.stringify(presentations)
  );
}

export function saveSettings(code, settings) {
  const presentations = JSON.parse(
    localStorage.getItem(storageKeys.presentations) || '{}'
  );
  const presentation = presentations[code];

  if (presentation) {
    presentation.settings = settings;

    presentations[code] = presentation;

    localStorage.setItem(
      storageKeys.presentations,
      JSON.stringify(presentations)
    );
  }
}

export function deletePresentation(code) {
  const presentations = JSON.parse(
    localStorage.getItem(storageKeys.presentations) || '{}'
  );
  delete presentations[code];

  localStorage.setItem(
    storageKeys.presentations,
    JSON.stringify(presentations)
  );
}
